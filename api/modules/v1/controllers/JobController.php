<?php

namespace api\modules\v1\controllers;

use api\modules\v1\matchEngine\MatcherAll;
use api\modules\v1\models\Job;
use api\modules\v1\models\Resume;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
* Job Controller API
*/
class JobController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Job';

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
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function () {
            return new ActiveDataProvider([
                'query' => Job::find(),
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
     * @return array|null|ActiveDataProvider|\yii\db\ActiveRecord
     */
    public function actionSearchJob()
    {
        // First of all: retrieve the user resume
        $resume = Resume::find()->where(['user_id' => \Yii::$app->user->id])->one();

        // Retrieve the active job list filtered by expired date
        $jobList = static::query(
            Job::find()
                ->where(['>', 'expired_at', new Expression('NOW()')])
                ->asArray()
        );

        // If the resume was found keep going
        if (!is_null($resume)) {
            /**
             * In this step we'll use the Match-engine to handle the comparison
             * between candidate resume and the offered jobs
             */
            $jobList = MatcherAll::match($resume, $jobList);

            return $jobList;
        }
        else {
            // Return all the active jobs without filtering by match engine
            return $jobList;
        }
    }
}