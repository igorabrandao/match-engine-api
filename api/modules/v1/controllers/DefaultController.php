<?php

namespace api\modules\v1\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
/**
 * Default controller for the `module` module
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Adding Http Bearer Authentication
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options', 'action-call']
        ];

        return $behaviors;
    }

    public function actionActionCall()
    {

        return ['msg'=> 'OK!'];

    }
}
