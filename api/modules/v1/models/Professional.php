<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professional".
 *
 * @property integer $id
 * @property integer $female
 * @property string $about
 * @property integer $professional_type_id
 *
 * @property CompanyHasProfessional[] $companyHasProfessionals
 * @property ProfessionalType $professionalType
 * @property ProfessionalHasAgeGroup[] $professionalHasAgeGroups
 * @property ProfessionalHasContact[] $professionalHasContacts
 * @property ProfessionalHasLead[] $professionalHasLeads
 * @property ProfessionalHasServiceType[] $professionalHasServiceTypes
 * @property ProfessionalHasSocialMedia[] $professionalHasSocialMedia
 * @property ProfessionalHasTag[] $professionalHasTags
 * @property ProfessionalHasUser[] $professionalHasUsers
 */
class Professional extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['female'], 'required'],
            [['female', 'professional_type_id'], 'integer'],
            [['about'], 'string'],
            [['professional_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProfessionalType::className(), 'targetAttribute' => ['professional_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'female' => 'Female',
            'about' => 'About',
            'professional_type_id' => 'Professional Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasProfessionals()
    {
        return $this->hasMany(CompanyHasProfessional::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalType()
    {
        return $this->hasOne(ProfessionalType::className(), ['id' => 'professional_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasAgeGroups()
    {
        return $this->hasMany(ProfessionalHasAgeGroup::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasContacts()
    {
        return $this->hasMany(ProfessionalHasContact::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasLeads()
    {
        return $this->hasMany(ProfessionalHasLead::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasServiceTypes()
    {
        return $this->hasMany(ProfessionalHasServiceType::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasSocialMedia()
    {
        return $this->hasMany(ProfessionalHasSocialMedia::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasTags()
    {
        return $this->hasMany(ProfessionalHasTag::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasUsers()
    {
        return $this->hasMany(ProfessionalHasUser::className(), ['professional_id' => 'id']);
    }
}
