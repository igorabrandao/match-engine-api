<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "state".
 *
 * @property integer $id
 * @property string $name
 * @property string $abbreviation
 *
 * @property City[] $cities
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'abbreviation'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['abbreviation'], 'string', 'max' => 2],
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
            'abbreviation' => 'Abbreviation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['state_id' => 'id']);
    }
}
