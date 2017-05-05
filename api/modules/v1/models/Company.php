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
 * @property string $complement
 * @property string $logo_id
 * @property integer $company_market_id
 * @property integer $price_range_id
 * @property integer $city_id
 * @property string $latitude
 * @property string longitude
 *
 * @property City $city
 * @property CompanyMarket $companyMarket
 * @property PriceRange $priceRange
 * @property Upload $logo
 * @property CompanyHasContact[] $companyHasContacts
 * @property CompanyHasLead[] $companyHasLeads
 * @property CompanyHasProfessional[] $companyHasProfessionals
 * @property CompanyHasServiceType[] $companyHasServiceTypes
 * @property CompanyHasSocialMedia[] $companyHasSocialMedia
 * @property CompanyHasTag[] $companyHasTags
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
            [['company_market_id', 'city_id'], 'integer'],
            [['cnpj', 'trading_name', 'company_name', 'street', 'district', 'complement'], 'string', 'max' => 255],
            [['cep'], 'string', 'max' => 16],
            [['address_number'], 'string', 'max' => 64],
            [['latitude'], 'string', 'max' => 18],
            [['longitude'], 'string', 'max' => 18],
            [['logo_id'], 'string', 'max' => 13],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['company_market_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyMarket::className(), 'targetAttribute' => ['company_market_id' => 'id']],
            [['price_range_id'], 'exist', 'skipOnError' => true, 'targetClass' => PriceRange::className(), 'targetAttribute' => ['price_range_id' => 'id']],
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
            'complement' => 'Complement',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'logo_id' => 'Logo ID',
            'company_market_id' => 'Company Market ID',
            'price_range_id' => 'Price Range ID',
            'city_id' => 'City ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        // Remove fields that contain sensitive information
        unset($fields['logo_id']);

        $fields['logo'] = 'logo';

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'market' => 'companyMarket',
            'priceRange' => 'priceRange',
            'city' => 'city',
            'state' => function () {
                return $this->city->state;
            },
            'logo',
            'lead',
            'contact',
            'professional',
            'serviceType',
            'tag',
            'user'
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
    public function getCompanyMarket()
    {
        return $this->hasOne(CompanyMarket::className(), ['id' => 'company_market_id']);
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
    public function getPriceRange()
    {
        return $this->hasOne(PriceRange::className(), ['id' => 'price_range_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasContacts()
    {
        return $this->hasMany(CompanyHasContact::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasMany(CompanyHasContact::className(), ['company_id' => 'id'])->via('companyHasContacts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasLeads()
    {
        return $this->hasMany(CompanyHasLead::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasMany(CompanyHasLead::className(), ['company_id' => 'id'])->via('companyHasLeads');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasProfessionals()
    {
        return $this->hasMany(CompanyHasProfessional::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessional()
    {
        return $this->hasMany(CompanyHasProfessional::className(), ['company_id' => 'id'])->via('companyHasProfessionals');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasServiceTypes()
    {
        return $this->hasMany(CompanyHasServiceType::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasMany(CompanyHasServiceType::className(), ['company_id' => 'id'])->via('companyHasServiceTypes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasSocialMedia()
    {
        return $this->hasMany(CompanyHasSocialMedia::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialMedia()
    {
        return $this->hasMany(CompanyHasSocialMedia::className(), ['company_id' => 'id'])->via('companyHasSocialMedia');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasTags()
    {
        return $this->hasMany(CompanyHasTag::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(CompanyHasTag::className(), ['company_id' => 'id'])->via('companyHasTags');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasUsers()
    {
        return $this->hasMany(CompanyHasUser::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(CompanyHasUser::className(), ['company_id' => 'id'])->via('companyHasUsers');
    }
}
