<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "company_has_contact".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $professional_id
 *
 * @property Contact $professional
 * @property Company $company
 */
class CompanyHasContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_has_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'professional_id'], 'integer'],
            [['professional_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['professional_id' => 'id']],
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
            'professional_id' => 'Professional ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessional()
    {
        return $this->hasOne(Contact::className(), ['id' => 'professional_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
