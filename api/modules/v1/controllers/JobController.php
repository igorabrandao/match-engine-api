<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Job;
use api\modules\v1\models\Resume;
use Yii;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
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

    private static function query($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
    }


    public function actionSearchJob()
    {
        // First of all: retrieve the user resume
        $resume = Resume::find()->where(['user_id' => \Yii::$app->user->id])->one();

        // If the resume was found keep going
        if (!is_null($resume)) {
            // TODO: Match-engine integration here!
            return $resume;
        }
        else {
            // Return all the active jobs without filtering by match engine
            return static::query(
                Job::find()
                    ->where(['<', 'expired_at', new Expression('NOW()')])
                    ->asArray()
            );
        }

    }
}