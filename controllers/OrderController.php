<?php
namespace app\controllers;

use app\common\Helper;
use app\models\AddressBook;
use app\models\Order;
use app\models\OrderProduct;
use app\models\OrderState;
use app\models\Unit;
use app\models\Waybill;
use app\models\WaybillState;
use yii\db\Exception;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class OrderController extends Controller{

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => 'user',
                'rules' => [
                    [
                        'actions' => ['quick', 'complete', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionQuick(){
        if(Yii::$app->request->post()){
            //print_r(Yii::$app->request->post());exit;
            $data = Yii::$app->request->post();
            //数据校验 先不做
            $order = new Order();
            $orderProduct = new OrderProduct();
            $orderState = new OrderState();
            $waybill = new Waybill();
            $waybillState = new WaybillState();

            $transaction = Yii::$app->db->beginTransaction();
            try{
                $mailingBook = AddressBook::find()->where(['address_book_id' => $data['mailing-address']])->one();
                $receivingBook = AddressBook::find()->where(['address_book_id' => $data['receiving-address']])->one();
                $orderSn = Helper::BuildOrderSn();
                //Yii::$app->session->setFlash('orderSn', $orderSn);
                $orderAttributes = [
                    'order_number' => $orderSn,
                    'state' => 1,
                    'member_id' => Yii::$app->user->identity->member_id,
                    'network_id' => $mailingBook->network_id,
                    'network_name' => $mailingBook->network_name,
                    'mailing_address_id' => $data['mailing-address'],
                    'mailing_address' => $mailingBook->address.' '.$mailingBook->gate,
                    'receiving_address_id' => $data['mailing-address'],
                    'receiving_address' => $receivingBook->address.' '.$receivingBook->gate,
                ];
                $order->setAttributes($orderAttributes);
                if($order->save()){
                    foreach($data['name'] as $i=>$name){
                        if(empty($name)) break;
                        $op = clone $orderProduct;
                        $lengthUnitId = $data['length-unit'][$i];
                        $weightUnitId = $data['weight-unit'][$i];
                        $lengthUnitName = Unit::GetUnitName($lengthUnitId);
                        $weightUnitName = Unit::GetUnitName($weightUnitId);
                        $opAttributes = [
                            'order_id' => $order->primaryKey,
                            'order_number' => $orderSn,
                            'name' => $name,
                            'description' => $data['des'][$i],
                            'quantity' => $data['qty'][$i],
                            'length' => $data['length'][$i],
                            'width' => $data['width'][$i],
                            'height' => $data['height'][$i],
                            'weight' => $data['weight'][$i],
                            'length_unit_id' => $lengthUnitId,
                            'length_unit_name' => $lengthUnitName,
                            'weight_unit_id' => $weightUnitId,
                            'weight_unit_name' => $weightUnitName,
                        ];
                        $op->setAttributes($opAttributes);
                        if(!$op->save()){
                            $error = array_values($op->getFirstErrors())[0];
                            throw new Exception('ORDER PRODUCT: '.$error);
                        }
                    }
                    $osAttributes = [
                        'order_id' => $order->primaryKey,
                        'order_number' => $orderSn,
                        'state' => 1,
                        'description' => 'order commit'
                    ];
                    $orderState->setAttributes($osAttributes);
                    if(!$orderState->save()){
                        $error = array_values($orderState->getFirstErrors())[0];
                        throw new Exception('ORDER STATE: '.$error);
                    }
                    $waybillNumber = Helper::BuildBillNumber();
                    $wbAttributes = [
                        'state' => 1,
                        'waybill_number' => $waybillNumber,
                        'order_id' => $order->primaryKey,
                        'order_number' => $orderSn
                    ];
                    $waybill->setAttributes($wbAttributes);
                    if($waybill->save()){
                        $wbsAttributes = [
                            'waybill_id' => $waybill->primaryKey,
                            'waybill_number' => $waybillNumber,
                            'state' => 1,
                            'description' => 'Order Create'
                        ];
                        $waybillState->setAttributes($wbsAttributes);
                        if(!$waybillState->save()){
                            $error = array_values($waybillState->getFirstErrors())[0];
                            throw new Exception('WAYBILL STATE: '.$error);
                        }
                    }else{
                        $error = array_values($waybill->getFirstErrors())[0];
                        throw new Exception('WAYBILL: '.$error);
                    }
                }else{
                    $error = array_values($order->getFirstErrors())[0];
                    throw new Exception('ORDER: '.$error);
                }
                $transaction->commit();
                return $this->render('complete', [
                    'orderSn' => $orderSn
                ]);
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->session->setFlash('error',$e->getMessage());
                return $this->render('quick');
            }
        }else{
            return $this->render('quick');
        }

    }

    public function actionComplete(){
        return $this->render('complete', [
            'orderSn' => Yii::$app->session->getFlash('orderSn')
        ]);
    }

    public function actionValidateForm(){

    }

    public function actionView($id){
        $order = Order::findOne($id);
        $mailing = AddressBook::findOne($order->mailing_address_id);
        $receiving = AddressBook::findOne($order->receiving_address_id);
        $products = OrderProduct::find()->where(['order_id' => $id])->all();
        //订单对应的路由信息


        return $this->render('view', [
            'order' => $order,
            'mailing' => $mailing,
            'receiving' => $receiving,
            'products' => $products,
        ]);
    }

}