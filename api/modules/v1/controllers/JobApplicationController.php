<?php

namespace api\modules\v1\controllers;

use api\modules\v1\matchEngine\DecisionMaker;
use api\modules\v1\matchEngine\DecisionMakerStrategy;
use api\modules\v1\models\JobApplication;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;

/**
 * JobApplication Controller API
 */
class JobApplicationController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\JobApplication';

    /**
     * @inheritdoc
     */
    public function behaviors ()
    {
        $behaviors = parent::behaviors();

        // Adding Http Bearer Authentication
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options']
        ];

        return $behaviors;
    }

    public function actions ()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function () {
            return new ActiveDataProvider([
                'query' => JobApplication::find(),
                'pagination' => [
                    'pageSizeLimit' => [0, 50],
                ],
            ]);
        };

        return $actions;
    }

    /**
     * @param $query
     * @return ActiveDataProvider
     */
    private static function query ($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
    }

    /**
     * Function to accept job applications
     * Use the match engine Decision Maker group of classes
     *
     * @param $id
     * @return void
     */
    public function actionAcceptApplication ($id)
    {
        // Retrieve the job application accordling to parameter
        if (!is_null($id)) {
            $jobApplication = JobApplication::find()
                ->where(['id' => $id])
                ->asArray()
                ->all();
        }
        // Retrieve all job applications
        else {
            $jobApplication = JobApplication::find()
                ->asArray()
                ->all();
        }

        // Check if some application was found
        if (empty($jobApplication)) {
            throw new NotFoundHttpException('Job Application not found.');
        }

        /**
         * Call the DecisionMakerStrategy to decide which decision implementation will be used
         */
        $decisionInstance = new DecisionMakerStrategy($jobApplication);

        // Define the job application status
        $jobApplication = $decisionInstance->decideMatch($jobApplication, DecisionMaker::ACCEPTED);

        // Run through all job applications
        foreach ($jobApplication as $key => $currentItem) {

            // Get the job application object
            $currentJobApplication = JobApplication::findOne($jobApplication[$key]['id']);

            // Add the status
            $currentJobApplication->status = $jobApplication[$key]['status'];

            // Update its status in DB
            $currentJobApplication->save();
        }
    }

    /**
     * Function to reject job applications
     * Use the match engine Decision Maker group of classes
     *
     * @param $id
     * @return void
     */
    public function actionRejectApplication ($id)
    {
        // Retrieve the job application accordling to parameter
        if (!is_null($id)) {
            $jobApplication = JobApplication::find()
                ->where(['id' => $id])
                ->asArray()
                ->all();
        }
        // Retrieve all job applications
        else {
            $jobApplication = JobApplication::find()
                ->asArray()
                ->all();
        }

        // Check if some application was found
        if (empty($jobApplication)) {
            throw new NotFoundHttpException('Job Application not found.');
        }

        /**
         * Call the DecisionMakerStrategy to decide which decision implementation will be used
         */
        $decisionInstance = new DecisionMakerStrategy($jobApplication);

        // Define the job application status
        $jobApplication = $decisionInstance->decideMatch($jobApplication, DecisionMaker::REJECTED);

        // Run through all job applications
        foreach ($jobApplication as $key => $currentItem) {

            // Get the job application object
            $currentJobApplication = JobApplication::findOne($jobApplication[$key]['id']);

            // Add the status
            $currentJobApplication->status = $jobApplication[$key]['status'];

            // Update its status in DB
            $currentJobApplication->save();
        }
    }

    /**
     * Function to check the job application status
     *
     * @param $id
     * @return void
     */
    public function actionCheckStatusApplication ($id)
    {
        // Retrieve the job application accordling to parameter
        if (!is_null($id)) {
            $jobApplication = JobApplication::find()->where(['id' => $id])->one();
        }

        // Check if some application was found
        if (empty($jobApplication)) {
            throw new NotFoundHttpException('Job Application not found.');
        }

        switch ($jobApplication->status) {
            case DecisionMaker::STATUS_NOT_DEFINED:
                return "Houve um problema com a sua aplicação, por favor tente novamente.";
                break;
            case DecisionMaker::WAITING_EVALUATION:
                return "A empresa ainda não avaliou a sua aplicação, estamos torcendo por você!";
                break;
            case DecisionMaker::REJECTED:
                return "Infelizmente a empresa não aceitou sua aplicação, mas não desanime. Temos várias ofertas de emprego disponíveis em nosso site.";
                break;
            case DecisionMaker::ACCEPTED:
                return "Parabéns! A empresa aceitou a sua aplicação, em breve um representante da empresa entrará em contato.";
                break;
            default:
                return "Houve um problema com a sua aplicação, por favor tente novamente.";
                break; // Needs to be handled
        }
    }
}