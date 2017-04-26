<?php
/**
 * Created by PhpStorm.
 * User: KING
 * Date: 15-12-16
 * Time: 下午5:37
 */

namespace app\modules\admin\models;
use Yii;
use yii\base\Model;

class ManagerLoginForm extends Model{

    public $username;
    public $password;
    public $verifyCode;

    private $_manager = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 32],
            ['password', 'validatePassword'],
            ['verifyCode', 'required'],
            ['verifyCode', 'captcha', 'captchaAction'=>'/admin/manager/captcha'],
        ];
    }

    public function attributeLabels(){
        return [
            'username' => 'Username',
            'password' => 'Password',
            'verifyCode' => 'Verify Code',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $manager = $this->getUser();

            if (!$manager || !$manager->validatePassword($this->password)) {
                $this->addError($attribute, 'Username Or Password Wrong!');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->admin->login($this->getUser(), 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Manager|null
     */
    public function getUser()
    {
        if ($this->_manager === false) {
            $this->_manager = Manager::findByUsername($this->username);
        }

        return $this->_manager;
    }

}