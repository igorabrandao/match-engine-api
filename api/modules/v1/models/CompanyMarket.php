<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "company_market".
 *
 * @property integer $id
 * @property string $description
 *
 * @property Company[] $companies
 */
class CompanyMarket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_market';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string', 'max' => 64],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['company_market_id' => 'id']);
    }
}
