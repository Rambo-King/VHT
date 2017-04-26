<?php
namespace app\api;
use yii\web\Controller;

class ApiController extends Controller{

    public function actionTest(){
        echo 'Hello Api';
    }

    public function actionIndex(){
        echo 'Hello Api Index';
    }

}