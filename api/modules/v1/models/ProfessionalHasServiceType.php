<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professional_has_service_type".
 *
 * @property integer $id
 * @property integer $professional_id
 * @property integer $service_type_id
 *
 * @property ServiceType $serviceType
 * @property Professional $professional
 */
class ProfessionalHasServiceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional_has_service_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['professional_id', 'service_type_id'], 'required'],
            [['professional_id', 'service_type_id'], 'integer'],
            [['service_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceType::className(), 'targetAttribute' => ['service_type_id' => 'id']],
            [['professional_id'], 'exist', 'skipOnError' => true, 'targetClass' => Professional::className(), 'targetAttribute' => ['professional_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'professional_id' => 'Professional ID',
            'service_type_id' => 'Service Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessional()
    {
        return $this->hasOne(Professional::className(), ['id' => 'professional_id']);
    }
}
