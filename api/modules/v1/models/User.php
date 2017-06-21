<?php

namespace api\modules\v1\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $is_admin
 * @property integer $is_active
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property string $access_token
 * @property string $password_reset_token
 * @property string $encrypted_password
 * @property string $expiration_date_reset_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CompanyHasUser[] $companyHasUsers
 * @property JobAlert[] $jobAlerts
 * @property JobApplication[] $jobApplications
 * @property Mobile[] $mobiles
 * @property Resume[] $resumes
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var string Unencrypted password
     */
    public $password;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required', 'on' => ['create', 'update']],
            [['password'], 'required', 'on' => ['create']],
            [['is_active', 'name', 'email'], 'required'],
            [['is_active'], 'integer'],
            [['expiration_date_reset_token', 'updated_at', 'created_at'], 'safe'],
            [['name', 'surname', 'email', 'phone', 'access_token', 'password_reset_token', 'encrypted_password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['email'], 'filter', 'filter' => 'strtolower'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        // Remove fields that contain sensitive information
        unset($fields['encrypted_password'], $fields['access_token']);

        // Only the current logged user can see it's own access_token
        $identity = Yii::$app->user->identity;
        if (!empty($identity) && ($identity->getId() == $this->id))
            $fields['access_token'] = 'access_token';

        // If the user is associated to a company, it`ll return the company ID
        $fields['company'] = 'company';

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_admin' => 'Is Admin',
            'is_active' => 'Is Active',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'phone' => 'Phone',
            'access_token' => 'Access Token',
            'password_reset_token' => 'Password Reset Token',
            'password' => 'Password',
            'encrypted_password' => 'Encrypted Password',
            'expiration_date_reset_token' => 'Expiration Date Reset Token',
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
            'company'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHasUsers()
    {
        return $this->hasMany(CompanyHasUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->via('companyHasUsers')->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobAlerts()
    {
        return $this->hasMany(JobAlert::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobApplications()
    {
        return $this->hasMany(JobApplication::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMobiles()
    {
        return $this->hasMany(Mobile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumes()
    {
        return $this->hasMany(Resume::className(), ['user_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                $this->encrypted_password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $this->access_token = null;
            }

            if ($this->scenario == 'create') {
                $this->access_token = Yii::$app->getSecurity()->generateRandomString();
                $this->is_active = 1;
            }

            if (!$this->is_active)
                $this->access_token = null;

            return true;
        } else {
            return false;
        }
    }
}
