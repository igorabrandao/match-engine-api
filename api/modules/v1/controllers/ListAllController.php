<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Company;
use api\modules\v1\models\Contact;
use api\modules\v1\models\Job;
use api\modules\v1\models\JobAlert;
use api\modules\v1\models\JobApplication;
use api\modules\v1\models\Resume;
use api\modules\v1\models\State;
use api\modules\v1\models\Tag;
use api\modules\v1\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * ListAll Controller API
 */
class ListAllController extends ActiveController
{
    public $modelClass = '';

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Adding Http Bearer Authentication
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['joint-owners', 'orders']
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
     * @return ActiveDataProvider
     */
    public function actionStates()
    {
        return static::query(
            State::find()
        );
    }

    /**
     * @param $id
     * @return ActiveDataProvider
     */
    public function actionCitiesFromState($id)
    {
        return static::query(
            State::findOne($id)->getCities()
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionCompanies()
    {
        return static::query(
            Company::find()->orderBy(['description' => 'asc'])
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionTags()
    {
        return static::query(
            Tag::find()->orderBy(['description' => 'asc'])
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionResumes()
    {
        return static::query(
            Resume::find()->orderBy(['professional_title' => 'asc'])
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionJobs()
    {
        return static::query(
            Job::find()->orderBy(['created_at' => 'desc'])
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionJobAlerts()
    {
        return static::query(
            JobAlert::find()->orderBy(['description' => 'asc'])
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionJobApplications()
    {
        return static::query(
            JobApplication::find()->orderBy(['created_at' => 'desc'])
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionContacts()
    {
        return static::query(
            Contact::find()->orderBy(['created_at' => 'desc'])
        );
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionUsers()
    {
        return static::query(
            User::find()->orderBy(['name' => 'asc'])
        );
    }
}