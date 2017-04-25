<?php
namespace app\models;
use yii\base\Model;

class MemberRegisterForm extends Model{

    public $email;
    public $password;
    public $password2;
    public $number;

    public function rules(){
        return [
            [['email', 'password', 'password2'], 'required'],
            ['number', 'string', 'max' => 12],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\Member'],
            ['password2', 'compare', 'compareAttribute'=>'password'],

            /*
            ['username', 'required'],
            ['username', 'match', 'pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}必须为1开头的11位纯数字'],
            ['username', 'unique', 'targetClass' => 'app\models\Member', 'message' => '{attribute}已被占用'],

            [['password', 'password2'], 'required'],
            ['password', 'string', 'min' => 6, 'max' => 16, 'message' => '{attribute}位数为6至16位'],

            ['password2', 'compare','compareAttribute'=>'password', 'message' => '两次密码不一致'],

            ['username', 'required', 'on' => ['stepOne']],
            ['username', 'match', 'pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}必须为1开头的11位纯数字', 'on' => ['stepOne']],
            ['username', 'unique', 'targetClass' => 'app\models\Member', 'message' => '{attribute}已被占用', 'on' => ['stepOne']],

            [['password', 'password2'], 'required', 'on' => ['stepTwo']],
            ['password', 'string', 'min' => 6, 'max' => 16, 'message' => '{attribute}位数为6至16位', 'on' => ['stepTwo']],

            ['password2', 'compare','compareAttribute'=>'password', 'message' => '两次密码不一致', 'on' => ['stepTwo']],
            */
        ];
    }

    public function attributeLabels(){
        return [
            'email' => 'Email',
            'password' => 'Password',
            'password2' => 'Confirm Password',
        ];
    }

    public function Register(){
        if($this->validate()){
            $member = new Member();
            $member->scenarios('add');
            $member->email = $this->email;
            $member->setPassword($this->password);
            $member->password2 = $member->password;
            $member->account_number = $this->number;
            $member->account_number = $member->account_number == '' ? null : $member->account_number;
            $member->created_at = time();
            $member->generateAuthKey();
            if($member->save()) return $member;
            else print_r($member->getErrors());
        }
        return null;
    }

}

