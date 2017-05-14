<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $title
 * @property string $message
 * @property string $name
 * @property string $email
 * @property string $created_at
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'message', 'name', 'email'], 'required'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['title', 'name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
            'name' => 'Name',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];
    }
}
