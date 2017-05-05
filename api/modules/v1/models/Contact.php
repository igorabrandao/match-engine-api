<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $title
 * @property string $message
 * @property string $created_at
 *
 * @property CompanyHasContact[] $companyHasContacts
 * @property ProfessionalHasContact[] $professionalHasContacts
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
            [['name', 'email', 'phone', 'title', 'message'], 'required'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['name', 'email', 'phone', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'title' => 'Title',
            'message' => 'Message',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasContacts()
    {
        return $this->hasMany(CompanyHasContact::className(), ['professional_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasContacts()
    {
        return $this->hasMany(ProfessionalHasContact::className(), ['contact_id' => 'id']);
    }
}
