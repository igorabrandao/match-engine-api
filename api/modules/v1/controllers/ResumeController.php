<?php

namespace api\modules\v1\controllers;

use api\modules\v1\matchEngine\MatchStrategy;
use api\modules\v1\models\Job;
use api\modules\v1\models\Resume;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
* Resume Controller API
*/
class ResumeController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Resume';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Adding Http Bearer Authentication
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options']
        ];

        return $behaviors;
    }

    /**
     * @param $query
     * @return ActiveDataProvider
     */
    private static function query($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
    }

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function () {
            return new ActiveDataProvider([
                'query' => Resume::find(),
                'pagination' => [
                    'pageSizeLimit' => [0, 50],
                ],
            ]);
        };

        return $actions;
    }

    /**
     * Function to search resumes accordling to companie job
     * Uses the Match engine
     *
     * @return array|object|\yii\db\ActiveRecord[]
     */
    public function actionSearchResume()
    {
        // Try to get the job ID if it was informed
        $job_id = Yii::$app->getRequest()->getQueryParam('job_id');

        // Try to get the company ID if it was informed
        $company_id = Yii::$app->getRequest()->getQueryParam('company_id');

        // Get the max number of resumes
        $resume_number = Yii::$app->getRequest()->getQueryParam('resume_number');

        // Retrieve the jobs accordling to parameter
        if (!is_null($job_id)) {
            // Get the specified job by its ID
            $job = Job::find()
                ->where(['id' => $job_id])
                ->asArray()
                ->one();
        }
        // Get all company's jobs
        else if (!is_null($company_id)) {
            $job = Job::find()
                ->select(['job.*'])
                ->join('INNER JOIN', 'company_has_job', 'company_has_job.job_id = job.id')
                ->join('INNER JOIN', 'company', 'company_has_job.company_id = company.id')
                ->andFilterWhere(['company_has_job.company_id' => $company_id])
                ->asArray();
        }
        // Get all jobs
        else {
            $job = Job::find()
                ->asArray()
                ->all();
        }

        /**
         * Retrieve all available resumes
         *
         * Note that available resumes mean that candidates that aren't hired yet,
         * that's why application status must be different from 2
         */
        $resumeList = Resume::find()
            ->select(['resume.*', 'job_application.status'])
            ->join('LEFT JOIN', 'job_application', 'resume.user_id = job_application.user_id')
            ->where(['job_application.status' => null])
            ->orFilterWhere(['<>', 'job_application.status', 2])
            ->asArray()
            ->all();

        /**
         * Call the MatchStrategy to decide which match implementation will be used
         */

        // Check the number of resumes was informed
        if (!is_null($resume_number)) {
            $matchInstance = new MatchStrategy($resumeList,$resume_number);
        }
        else {
            $matchInstance = new MatchStrategy($resumeList,null,0.5);
        }

        // If the job was found keep going
        if (!is_null($job)) {
            /**
             * In this step we'll use the Match-engine to handle the comparison
             * between offered job(s) and candidates resumes
             */
            $resumeList = $matchInstance->match($job, $resumeList);

            // Return the filtered jobList by Match engine
            return $resumeList;
        }
        else {
            // Return all the active resumes without filtering by match engine
            return $resumeList;
        }
    }
}