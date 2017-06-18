<?php

namespace app\modules\v1\controllers;

use api\modules\v1\models\CompanyHasJob;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;

/**
* CompanyHasJob Controller API
*/
class CompanyHasJobController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\CompanyHasJob';

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
                'query' => CompanyHasJob::find(),
                'pagination' => [
                    'pageSizeLimit' => [0, 50],
                ],
            ]);
        };

        return $actions;
    }
}
