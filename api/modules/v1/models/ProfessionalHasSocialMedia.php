<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professional_has_social_media".
 *
 * @property integer $id
 * @property integer $professional_id
 * @property integer $social_media_id
 *
 * @property SocialMedia $socialMedia
 * @property Professional $professional
 */
class ProfessionalHasSocialMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional_has_social_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['professional_id', 'social_media_id'], 'integer'],
            [['social_media_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialMedia::className(), 'targetAttribute' => ['social_media_id' => 'id']],
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
            'social_media_id' => 'Social Media ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialMedia()
    {
        return $this->hasOne(SocialMedia::className(), ['id' => 'social_media_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessional()
    {
        return $this->hasOne(Professional::className(), ['id' => 'professional_id']);
    }
}
