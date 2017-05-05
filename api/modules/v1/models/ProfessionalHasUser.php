<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professional_has_user".
 *
 * @property integer $id
 * @property integer $professional_id
 * @property integer $user_id
 *
 * @property User $user
 * @property Professional $professional
 */
class ProfessionalHasUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional_has_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['professional_id', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessional()
    {
        return $this->hasOne(Professional::className(), ['id' => 'professional_id']);
    }
}
