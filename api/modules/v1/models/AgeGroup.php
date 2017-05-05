<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "age_group".
 *
 * @property integer $id
 * @property string $description
 * @property integer $min_age
 * @property integer $max_age
 *
 * @property ProfessionalHasAgeGroup[] $professionalHasAgeGroups
 */
class AgeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'age_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'min_age', 'max_age'], 'required'],
            [['min_age', 'max_age'], 'integer'],
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
            'min_age' => 'Min Age',
            'max_age' => 'Max Age',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasAgeGroups()
    {
        return $this->hasMany(ProfessionalHasAgeGroup::className(), ['age_group_id' => 'id']);
    }
}
