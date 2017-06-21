<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Category;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Home Controller API
 */
class HomeController extends ActiveController
{
    public $modelClass = '';

    private static function query($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
    }

    public function actionCategories()
    {
        return static::query(
            Yii::app()->db->createCommand()
                ->select(['c.id', 'c.description', 'job_count' => 'sum(contact_count)'])
                ->from('category c')
                ->join('job_has_category jhc', 'c.id=jhc.category_id')
                ->queryRow()
        );
    }
}