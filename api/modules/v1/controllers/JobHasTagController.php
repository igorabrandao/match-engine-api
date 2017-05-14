<?php

namespace app\modules\v1\controllers;

use api\modules\v1\models\JobHasTag;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;

/**
* JobHasTag Controller API
*/
class JobHasTagController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\JobHasTag';

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
                'query' => JobHasTag::find(),
                'pagination' => [
                    'pageSizeLimit' => [0, 50],
                ],
            ]);
        };

        return $actions;
    }
}
