<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\State;
use api\modules\v1\models\Company;
use api\modules\v1\models\CompanyMarket;
use api\modules\v1\models\Tag;
use api\modules\v1\models\TagType;
use api\modules\v1\models\ProfessionalType;
use api\modules\v1\models\AgeGroup;
use api\modules\v1\models\PriceRange;
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

    public function actionCompanies()
    {
        return static::query(
            Company::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionCompanyMarkets()
    {
        return static::query(
            CompanyMarket::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionTag()
    {
        return static::query(
            Tag::find()->orderBy(['name' => 'asc'])
        );
    }

    public function actionTagTypes()
    {
        return static::query(
            TagType::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionProfessional()
    {
        return static::query(
            User::find()->orderBy(['name' => 'asc'])
        );
    }

    public function actionProfessionalTypes()
    {
        return static::query(
            ProfessionalType::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionAgeGroups()
    {
        return static::query(
            AgeGroup::find()->orderBy(['description' => 'asc'])
        );
    }

    public function actionPriceRanges()
    {
        return static::query(
            PriceRange::find()->orderBy(['min_price' => 'asc'])
        );
    }
}