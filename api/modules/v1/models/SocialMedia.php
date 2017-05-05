<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "social_media".
 *
 * @property integer $id
 * @property string $facebook
 * @property string $twitter
 * @property string $google_plus
 * @property string $instagram
 * @property string $linkedin
 * @property string $site
 *
 * @property CompanyHasSocialMedia[] $companyHasSocialMedia
 * @property ProfessionalHasSocialMedia[] $professionalHasSocialMedia
 */
class SocialMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'social_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facebook', 'twitter', 'google_plus', 'instagram', 'linkedin', 'site'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'google_plus' => 'Google Plus',
            'instagram' => 'Instagram',
            'linkedin' => 'Linkedin',
            'site' => 'Site',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasSocialMedia()
    {
        return $this->hasMany(CompanyHasSocialMedia::className(), ['social_media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasSocialMedia()
    {
        return $this->hasMany(ProfessionalHasSocialMedia::className(), ['social_media_id' => 'id']);
    }
}
