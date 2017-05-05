<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "price_range".
 *
 * @property integer $id
 * @property string $description
 * @property string $min_price
 * @property string $max_price
 *
 * @property Company[] $companies
 * @property Professional[] $professionals
 */
class PriceRange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price_range';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['min_price', 'max_price'], 'number'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'min_price' => 'Min Price',
            'max_price' => 'Max Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['price_range_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionals()
    {
        return $this->hasMany(Professional::className(), ['price_range_id' => 'id']);
    }
}
