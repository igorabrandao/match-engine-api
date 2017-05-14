<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $description
 *
 * @property JobHasCategory[] $jobHasCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobHasCategories()
    {
        return $this->hasMany(JobHasCategory::className(), ['category_id' => 'id']);
    }
}
