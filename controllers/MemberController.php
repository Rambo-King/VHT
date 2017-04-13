<?php
namespace app\controllers;

use app\models\MemberLoginForm;
use app\models\MemberRegisterForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class MemberController extends Controller{

    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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
            return $this->goHome();
        }else{
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

}