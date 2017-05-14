<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "resume".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $professional_title
 * @property string $resume
 * @property string $education
 * @property string $work_experience
 * @property string $language
 * @property double $rate
 * @property string $photo_id
 * @property string $video
 * @property string $cep
 * @property string $street
 * @property string $district
 * @property string $address_number
 * @property string $logo_id
 * @property integer $city_id
 * @property string $facebook
 * @property string $twitter
 * @property string $google_plus
 * @property string $instagram
 * @property string $linkedin
 * @property string $site
 *
 * @property Logo $photo
 * @property User $user
 * @property ResumeHasTag[] $resumeHasTags
 */
class Resume extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resume';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'city_id'], 'integer'],
            [['professional_title', 'resume', 'rate'], 'required'],
            [['resume', 'education', 'work_experience', 'language'], 'string'],
            [['rate'], 'number'],
            [['professional_title', 'video', 'street', 'district', 'facebook', 'twitter', 'google_plus', 'instagram', 'linkedin', 'site'], 'string', 'max' => 255],
            [['photo_id', 'logo_id'], 'string', 'max' => 13],
            [['cep'], 'string', 'max' => 16],
            [['address_number'], 'string', 'max' => 64],
            [['photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Logo::className(), 'targetAttribute' => ['photo_id' => 'id']],
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
            'professional_title' => 'Professional Title',
            'resume' => 'Resume',
            'education' => 'Education',
            'work_experience' => 'Work Experience',
            'language' => 'Language',
            'rate' => 'Rate',
            'photo_id' => 'Photo ID',
            'video' => 'Video',
            'cep' => 'Cep',
            'street' => 'Street',
            'district' => 'District',
            'address_number' => 'Address Number',
            'logo_id' => 'Logo ID',
            'city_id' => 'City ID',
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
    public function getPhoto()
    {
        return $this->hasOne(Logo::className(), ['id' => 'photo_id']);
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
    public function getResumeHasTags()
    {
        return $this->hasMany(ResumeHasTag::className(), ['resume_id' => 'id']);
    }
}
