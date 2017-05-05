<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "company_has_social_media".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $social_media_id
 *
 * @property SocialMedia $socialMedia
 * @property Company $company
 */
class CompanyHasSocialMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_has_social_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'social_media_id'], 'integer'],
            [['social_media_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialMedia::className(), 'targetAttribute' => ['social_media_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
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
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
