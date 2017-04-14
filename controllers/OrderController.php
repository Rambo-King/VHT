<?php
namespace app\controllers;

use app\common\Helper;
use yii\web\Controller;

class OrderController extends Controller{

    public function actionQuick(){
        $orderSn = Helper::BuildOrderSn();
        var_export($orderSn);
        exit;
        return $this->render('quick');

        /*
         * 发件地址  收件地址  产品清单
         * */
    }

}