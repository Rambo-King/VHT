<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property integer $member_id
 * @property string $email
 * @property string $password
 * @property string $account_number
 * @property string $company_name
 * @property string $auth_key
 * @property string $access_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Member extends ActiveRecord implements IdentityInterface
{
    /*
     * 根据 token 查询身份。
     * @param string $token 被查询的 token
     * @return IdentityInterface|null 通过 token 得到的身份对象
     */
    public static function findIdentityByAccessToken($token, $type = null){
        return static::findOne(['access_token' => $token]);
    }

    /*
    * 根据给到的ID查询身份
    * @param string|integer $id 被查询的ID
    * @return IdentityInterface|null 通过ID匹配到的身份对象
    */
    public static function findIdentity($id){
        return static::findOne($id);
    }

    /* @return int|string 当前用户ID
     */
    public function getId(){
        return $this->member_id;
    }

    /* @return string 当前用户的（cookie）认证密钥
     */
    public function getAuthKey(){
        return $this->auth_key;
    }

    /*
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey){
        return $this->auth_key === $authKey;
    }

    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password); //使用yii2自带hash加密
    }

    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /*
    * 根据 用户名 查询身份。
    * @return IdentityInterface
    */
    public static function findByEmailOrNumber($emailOrNumber){
        $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
        // '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$'  '\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*'
        $temp = ['account_number' => $emailOrNumber];
        if(preg_match($pattern, $emailOrNumber)){
            $temp = ['email' => $emailOrNumber];
        }
        $member = Member::find()->where($temp)->asArray()->one();
        if ($member) {
            return new static($member);
        }
        return null;
    }

    public $password2;
    public $password3;
    public $password4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    public function behaviors(){
        return [
            /*[
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],*/
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function scenarios(){
        $parentScenarios = parent::scenarios();
        $selfScenarios = [
            'add' => ['email', 'password', 'password2', 'account_number', 'company_name'],
            'update' => ['account_number', 'company_name'],
            'change' => ['password3', 'password4'],
        ];
        return array_merge($parentScenarios, $selfScenarios);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'password2'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['email', 'account_number', 'auth_key'], 'string', 'max' => 32],
            [['password', 'company_name', 'access_token'], 'string', 'max' => 255],
            [['email', 'account_number'], 'unique', 'targetClass' => 'app\models\Member'],
            ['password2', 'compare', 'compareAttribute'=>'password'],

            [['password3', 'password4'], 'required', 'on' => 'change'],
            ['password4', 'compare', 'compareAttribute'=>'password3'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'account_number' => 'Account Number',
            'company_name' => 'Company Name',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
            'password2' => 'Confirm Password',
            'password3' => 'New Password',
            'password4' => 'Confirm Password',
        ];
    }

    public static function MemberList(){
        $rows = self::find()->all();
        return ArrayHelper::map($rows, 'member_id', 'email');
    }
}
