<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "mobile".
 *
 * @property integer $id
 * @property string $registration
 * @property string $os
 * @property integer $user_id
 *
 * @property User $user
 */
class Mobile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration', 'os'], 'required'],
            [['registration'], 'string'],
            [['user_id'], 'integer'],
            [['os'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration' => 'Registration',
            'os' => 'Os',
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
}
