<?php

namespace app\models;

use Yii;
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'created_at'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['email', 'account_number', 'company_name', 'auth_key'], 'string', 'max' => 32],
            [['password', 'access_token'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['account_number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'email' => 'Email',
            'password' => 'Password',
            'account_number' => 'Account Number',
            'company_name' => 'Company Name',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
        ];
    }

    public static function MemberList(){
        $rows = self::find()->all();
        return ArrayHelper::map($rows, 'member_id', 'email');
    }
}
