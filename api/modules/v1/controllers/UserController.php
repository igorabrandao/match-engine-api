<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\UnauthorizedHttpException;

/**
 * User Controller API
 */
class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';
    public $createScenario = 'create';
    public $updateScenario = 'update';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Adding Http Bearer Authentication
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options', 'login', 'recover-password', 'reset-password']
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function () {
            return new ActiveDataProvider([
                'query' => User::find(),
                'pagination' => [
                    'pageSizeLimit' => [0, 50],
                ],
            ]);
        };

        return $actions;
    }

    /**
     * @return User
     * @throws UnauthorizedHttpException
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        /** @var User $user */
        $user = User::findOne(['email' => $request->post('email')]);

        if (empty($user) || !Yii::$app->getSecurity()->validatePassword($request->post('password'), $user->encrypted_password) || !$user->is_active) {
            throw new UnauthorizedHttpException();
        }

        $user->access_token = Yii::$app->getSecurity()->generateRandomString();

        if ($user->save()) {
            Yii::$app->user->login($user);
        }

        return $user;
    }
    public function actionFindByEmail()
    {
        return User::findOne(['email' => Yii::$app->request->post('email')]);
    }
}