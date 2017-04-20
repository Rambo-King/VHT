<?php
namespace app\controllers;

use app\models\MemberLoginForm;
use app\models\MemberRegisterForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class MemberController extends Controller{

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => 'user',
                'rules' => [
                    [
                        'actions' => ['logout', 'account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    private function MemberLoginId(){
        return Yii::$app->user->identity->member_id;
    }

    public function actionRegister(){
        $model = new MemberRegisterForm();
        if($model->load(Yii::$app->request->post()) && $member = $model->Register()){
            Yii::$app->getUser()->login($member);
            return $this->goHome();
        }else{
            return $this->render('register', ['model' => $model]);
        }
    }

    public function actionLogin(){
        $model = new MemberLoginForm();
        if($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->goBack();
        }else{
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionAccount(){
        return $this->render('account', [
            'email' => Yii::$app->user->identity->email,
        ]);
    }

    public function actionInformation(){

        $this->MemberLoginId();
    }

    public function actionBook(){

    }

    public function actionOrder(){

    }

}