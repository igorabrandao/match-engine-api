<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $job_type_id
 * @property integer $city_id
 * @property double $rate
 * @property string $requirement
 * @property string $created_at
 * @property string $updated_at
 * @property string $expired_at
 *
 * @property City $city
 * @property JobType $jobType
 * @property JobApplication[] $jobApplications
 * @property JobHasCategory[] $jobHasCategories
 * @property JobHasTag[] $jobHasTags
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'requirement'], 'required'],
            [['description', 'requirement'], 'string'],
            [['job_type_id', 'city_id'], 'integer'],
            [['rate'], 'number'],
            [['created_at', 'updated_at', 'expired_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['job_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobType::className(), 'targetAttribute' => ['job_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'job_type_id' => 'Job Type ID',
            'city_id' => 'City ID',
            'rate' => 'Rate',
            'requirement' => 'Requirement',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'expired_at' => 'Expired At',
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
            'company',
            'jobType'
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
    public function getJobType()
    {
        return $this->hasOne(JobType::className(), ['id' => 'job_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobApplications()
    {
        return $this->hasMany(JobApplication::className(), ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobHasCategories()
    {
        return $this->hasMany(JobHasCategory::className(), ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobHasTags()
    {
        return $this->hasMany(JobHasTag::className(), ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasJobs()
    {
        return $this->hasMany(CompanyHasJob::className(), ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->via('companyHasJobs')->one();
    }
}
