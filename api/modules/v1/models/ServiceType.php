<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "service_type".
 *
 * @property integer $id
 * @property string $description
 *
 * @property CompanyHasServiceType[] $companyHasServiceTypes
 * @property ProfessionalHasServiceType[] $professionalHasServiceTypes
 */
class ServiceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasServiceTypes()
    {
        return $this->hasMany(CompanyHasServiceType::className(), ['service_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasServiceTypes()
    {
        return $this->hasMany(ProfessionalHasServiceType::className(), ['service_type_id' => 'id']);
    }
}
