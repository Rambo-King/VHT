<?php
namespace app\modules\api\controllers;
use yii\rest\ActiveController;
use yii\web\Response;

class UnitController extends ActiveController{

    public $modelClass = 'app\models\Unit';

    public function behaviors(){
        $behaviors = parent::behaviors();
        #定义返回格式是：JSON
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions(){
        $actions = parent::actions();
        //注销系统自带的实现方法
        //unset($actions['index']);
        return $actions;
    }

    public function actionTest(){
        exit(json_encode(['msg' => 'Test Action']));
    }

}