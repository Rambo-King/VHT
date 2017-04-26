<?php
namespace app\models;
use yii\base\Model;
use Yii;

class MemberLoginForm extends Model{

    public $email;
    public $password;
    private $_member = false;

    public function rules(){
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels(){
        return [
            'email' => 'Email/Account Number',
            'password' => 'Password',
        ];
    }

    /**
     * Finds user by [[Email]]
     *
     * @return Member|null
     */
    public function getUser(){
        if ($this->_member === false) {
            $this->_member = Member::findByEmailOrNumber($this->email);
        }
        return $this->_member;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Email / Account Number Or Password Wrong!');
            }
        }
    }

    public function login(){
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 0);
        }
        return false;
    }

}

