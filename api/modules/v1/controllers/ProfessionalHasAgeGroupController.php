<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\ProfessionalHasAgeGroup;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;

/**
* ProfessionalHasAgeGroup Controller API
*/
class ProfessionalHasAgeGroupController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\models\ProfessionalHasAgeGroup';

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
                'query' => ProfessionalHasAgeGroup::find(),
                'pagination' => [
                    'pageSizeLimit' => [0, 50],
                ],
            ]);
        };

        return $actions;
    }
}
