<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professional_has_age_group".
 *
 * @property integer $id
 * @property integer $professional_id
 * @property integer $age_group_id
 *
 * @property AgeGroup $ageGroup
 * @property Professional $professional
 */
class ProfessionalHasAgeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional_has_age_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['professional_id', 'age_group_id'], 'integer'],
            [['age_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgeGroup::className(), 'targetAttribute' => ['age_group_id' => 'id']],
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
            'age_group_id' => 'Age Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgeGroup()
    {
        return $this->hasOne(AgeGroup::className(), ['id' => 'age_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessional()
    {
        return $this->hasOne(Professional::className(), ['id' => 'professional_id']);
    }
}
