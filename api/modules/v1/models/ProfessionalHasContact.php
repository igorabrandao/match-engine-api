<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professional_has_contact".
 *
 * @property integer $id
 * @property integer $professional_id
 * @property integer $contact_id
 *
 * @property Contact $contact
 * @property Professional $professional
 */
class ProfessionalHasContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professional_has_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['professional_id', 'contact_id'], 'integer'],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['contact_id' => 'id']],
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
            'contact_id' => 'Contact ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessional()
    {
        return $this->hasOne(Professional::className(), ['id' => 'professional_id']);
    }
}
