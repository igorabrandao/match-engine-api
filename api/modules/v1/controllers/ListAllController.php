<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Category;
use api\modules\v1\models\State;
use api\modules\v1\models\Company;
use api\modules\v1\models\Job;
use api\modules\v1\models\JobAlert;
use api\modules\v1\models\JobApplication;
use api\modules\v1\models\JobType;
use api\modules\v1\models\Tag;
use api\modules\v1\models\Resume;
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
     * @inheritdoc
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

    private static function query($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
    }

    public function actionStates()
    {
        return static::query(
            State::find()
        );
    }

    public function actionCitiesFromState($id)
    {
        return static::query(
            State::findOne($id)->getCities()
        );
    }

    public function actionCategories()
    {
        return static::query(
            Category::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionCompanies()
    {
        return static::query(
            Company::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionJobs()
    {
        return static::query(
            Job::find()->orderBy(['created_at' => 'desc'])
        );
    }

    public function actionJobTypes()
    {
        return static::query(
            JobType::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionJobApplications()
    {
        return static::query(
            JobApplication::find()->orderBy(['created_at' => 'asc'])
        );
    }

    public function actionJobAlerts()
    {
        return static::query(
            JobAlert::find()->orderBy(['title' => 'asc'])
        );
    }

    public function actionTags()
    {
        return static::query(
            Tag::find()->orderBy(['name' => 'asc'])
        );
    }

    public function actionResumes()
    {
        return static::query(
            Resume::find()->orderBy(['professional_title' => 'asc'])
        );
    }
}