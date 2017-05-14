<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "logo".
 *
 * @property string $id
 * @property string $ext
 * @property string $created_at
 *
 * @property Company[] $companies
 * @property Resume[] $resumes
 */
class Logo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ext'], 'required'],
            [['created_at'], 'safe'],
            [['id'], 'string', 'max' => 13],
            [['ext'], 'string', 'max' => 4],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ext' => 'Ext',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['logo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumes()
    {
        return $this->hasMany(Resume::className(), ['photo_id' => 'id']);
    }
}
