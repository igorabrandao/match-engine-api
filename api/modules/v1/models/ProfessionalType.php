<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professional_type".
 *
 * @property integer $id
 * @property string $description
 *
 * @property Professional[] $professionals
 */
class ProfessionalType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional_type';
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
    public function getProfessionals()
    {
        return $this->hasMany(Professional::className(), ['professional_type_id' => 'id']);
    }
}
