<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $description
 * @property integer $tag_type_id
 *
 * @property CompanyHasTag[] $companyHasTags
 * @property ProfessionalHasTag[] $professionalHasTags
 * @property TagType $tagType
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['tag_type_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['tag_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TagType::className(), 'targetAttribute' => ['tag_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'tag_type_id' => 'Tag Type ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'tagType'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasTags()
    {
        return $this->hasMany(CompanyHasTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionalHasTags()
    {
        return $this->hasMany(ProfessionalHasTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagType()
    {
        return $this->hasOne(TagType::className(), ['id' => 'tag_type_id']);
    }
}
