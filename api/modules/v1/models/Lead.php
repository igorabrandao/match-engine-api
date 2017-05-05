<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "lead".
 *
 * @property integer $id
 * @property integer $click_count
 * @property integer $view_count
 * @property integer $contact_count
 *
 * @property CompanyHasLead[] $companyHasLeads
 * @property ProfessionalHasLead[] $professionalHasLeads
 */
class Lead extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_count', 'view_count', 'contact_count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'click_count' => 'Click Count',
            'view_count' => 'View Count',
            'contact_count' => 'Contact Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasLeads()
    {
        return $this->hasMany(CompanyHasLead::className(), ['lead_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasLeads()
    {
        return $this->hasMany(ProfessionalHasLead::className(), ['lead_id' => 'id']);
    }
}
