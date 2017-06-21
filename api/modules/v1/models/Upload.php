<?php

namespace api\modules\v1\models;

use api\helpers\ImageHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%upload}}".
 *
 * @property string $id
 * @property string $ext
 * @property string $created_at
 *
 * @property Company[] $companies
 * @property Professional[] $professionals
 * @property Gallery[] $galleries
 */
class Upload extends ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%upload}}';
    }
    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['created_at'] = function ($model) {
            /** @var static $model */
            return date('c', strtotime($model->created_at));
        };

        $fields['url'] = function ($model) {
            /** @var Upload $model */
            return $model->getUrl();
        };

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, pdf'],
            [['file'], 'required', 'on' => 'create'],
            [['id', 'ext'], 'required', 'on' => 'update'],
            [['created_at'], 'safe'],
            [['id'], 'string', 'max' => 13],
            [['ext'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'ext' => 'Extension',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['logo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessionals()
    {
        return $this->hasMany(Professional::className(), ['profile_image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleries()
    {
        return $this->hasMany(Gallery::className(), ['upload_id' => 'id']);
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->scenario == 'create')
            $this->created_at = date('Y-m-d H:i:s');

        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->refresh();

        if ($insert) {
            $dir = dirname($this->getPath());

            if (!is_dir($dir))
                mkdir($dir, 0755, true);

            $this->file->saveAs($this->getPath());

            $image = new ImageHelper();
            $image->originFile = $this->getPath();
            $image->resize();
            $image->save($this->getPath());
        }
    }
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $file = $this->getPath();
        if (file_exists($file))
            unlink($file);
    }

    /**
     * Retrieve the uploaded file location on the filesystem
     * @return string Full path to the file
     */
    public function getPath()
    {
        $creation_date = strtotime($this->created_at);
        $year = date('Y', $creation_date);
        $month = date('m', $creation_date);
        $uploadPathAlias = Yii::$app->params['uploadPathAlias'];
        return Yii::getAlias("{$uploadPathAlias}/{$year}/{$month}/{$this->id}.{$this->ext}");
    }

    /**
     * Retrieve the uploaded file URL
     * @return string Full URL to the file
     */
    public Function getUrl()
    {
        $creation_date = strtotime($this->created_at);
        $year = date('Y', $creation_date);
        $month = date('m', $creation_date);
        $uploadUrlAlias = Yii::$app->params['uploadUrlAlias'];
        return Url::to("{$uploadUrlAlias}/{$year}/{$month}/{$this->id}.{$this->ext}", true);
    }
}