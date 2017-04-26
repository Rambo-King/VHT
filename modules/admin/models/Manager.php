<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%manager}}".
 *
 * @property integer $manager_id
 * @property integer $role_id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $account_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Manager extends ActiveRecord implements IdentityInterface
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
        return $this->manager_id;
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
        $this->password = Yii::$app->security->generatePasswordHash($password);
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
    public static function findByUsername($username){
        $manager = Manager::find()->where(['username' => $username])->asArray()->one();
        if ($manager) {
            return new static($manager);
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
        return '{{%manager}}';
    }

    public function behaviors(){
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
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
            'add' => ['role_id', 'username', 'password', 'password2', 'account_name'],
            'modify' => ['role_id', 'account_name'],
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
            [['role_id', 'username', 'password', 'account_name'], 'required'],
            [['role_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password', 'access_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['password2'], 'required'],
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
            'manager_id' => 'ID',
            'role_id' => 'Role',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
            'password2' => 'Confirm Password',
            'password3' => 'New Password',
            'password4' => 'Confirm Password',
            'account_name' => 'Account Name',
        ];
    }

    public function Add(){
        if($this->validate()){
            $manager = new Manager();
            $manager->role_id = $this->role_id;
            $manager->username = $this->username;
            $manager->setPassword($this->password);
            $manager->password2 = $manager->password;
            $manager->account_name = $this->account_name;
            $manager->generateAuthKey();
            if($manager->save()) return $manager;
            else print_r($manager->getErrors());
        }
        return null;
    }

    public static function Roles(){
        return [
            1 => 'Super Admin',
            2 => 'Admin',
        ];
    }

    public static function GetRole($id){
        $roles = self::Roles();
        return $roles[$id];
    }

    public static function ManagerList(){
        $rows = self::find()->all();
        return ArrayHelper::map($rows, 'manager_id', 'account_name');
    }

    public static function GetAccountName($id){
        if(is_null($id)) return null;
        if($id == 0) return 'SELF';
        $row = self::find()->where(['manager_id' => $id])->one();
        return $row ? $row->account_name : null;
    }

}
