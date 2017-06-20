<?php

namespace api\modules\v1\controllers;

use api\modules\v1\DecisionMakerEngine\DecisionMakerStrategy;
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

    public function actions()
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
    private static function query($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
    }

    /**
     * @param $id
     * @return static
     */
    public function actionDecideApplication($id)
    {
        $jobApplication = JobApplication::findOne($id);

        $status = Yii::app()->request->getQuery('status');

        if(empty($jobApplication)) {
            throw new NotFoundHttpException('Job Application not found.');
        }

        /**
         * Call the MatchStrategy to decide which decision implementation will be used
         */
        $decisionInstance = new DecisionMakerStrategy($jobApplication);

        // Define the job application status
        $decisionInstance->decideMatch($jobApplication, $status);
    }
}