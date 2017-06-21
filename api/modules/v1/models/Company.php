<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $cnpj
 * @property string $trading_name
 * @property string $company_name
 * @property string $about
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
 * @property string $created_at
 * @property string $updated_at
 *
 * @property City $city
 * @property Logo $logo
 * @property CompanyHasUser[] $companyHasUsers
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cnpj', 'trading_name', 'company_name', 'street'], 'required'],
            [['about'], 'string'],
            [['city_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['cnpj', 'trading_name', 'company_name', 'street', 'district', 'facebook', 'twitter', 'google_plus', 'instagram', 'linkedin', 'site'], 'string', 'max' => 255],
            [['cep'], 'string', 'max' => 16],
            [['address_number'], 'string', 'max' => 64],
            [['logo_id'], 'string', 'max' => 13],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['logo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Upload::className(), 'targetAttribute' => ['logo_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cnpj' => 'Cnpj',
            'trading_name' => 'Trading Name',
            'company_name' => 'Company Name',
            'about' => 'About',
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'city' => 'city',
            'state' => function () {
                return $this->city->state;
            },
            'logo',
            'users'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogo()
    {
        return $this->hasOne(Upload::className(), ['id' => 'logo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasUsers()
    {
        return $this->hasMany(CompanyHasUser::className(), ['company_id' => 'id']);
    }
}
