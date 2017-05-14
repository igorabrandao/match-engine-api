<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "job_alert".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $keywords
 * @property string $frequency
 * @property integer $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $expire_at
 *
 * @property User $user
 */
class JobAlert extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_alert';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'is_active'], 'integer'],
            [['title', 'is_active'], 'required'],
            [['created_at', 'updated_at', 'expire_at'], 'safe'],
            [['title', 'keywords', 'frequency'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'frequency' => 'Frequency',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'expire_at' => 'Expire At',
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
