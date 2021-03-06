<?php
namespace app\controllers;

use app\models\AddressBook;
use app\models\AddressLibrary;
use app\modules\admin\models\Network;
use Yii;
use yii\web\Controller;

class BookController extends Controller{

    public function actionModify($id){
        $model = AddressBook::find()->where(['address_book_id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('AddressBook');
            $library = AddressLibrary::find()->where(['Address_Library_Id' => $data['areas']])->one();
            $mid = Yii::$app->user->identity->getId();
            $attributes = [
                'network_id' => $library->Network_Id,
                'network_name' => Network::GetNameById($library->Network_Id),
                'address_library_id' => $data['areas'],
                'address' => AddressLibrary::AddressString($data['areas']),
            ];
            $model->setAttributes($attributes);
            if($model->save()){
                if($model->is_default == 1){
                    AddressBook::updateAll(['is_default' => 0], ['member_id' => $mid, 'type' => $model->type]);
                }
                Yii::$app->session->setFlash('success', 'Update Success!');
                return $this->redirect(['/member/book']);
            }else{
                print_r($model->getErrors()); exit;
            }
        } else {
            $library = AddressLibrary::find()->where(['Address_Library_Id' => $model->address_library_id])->one();
            $model->country = $library->Country;
            $model->region1 = $library->Region1;
            $model->areas = $library->Address_Library_Id;
            return $this->render('modify', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate(){
        $model = new AddressBook();
        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('AddressBook');
            $library = AddressLibrary::find()->where(['Address_Library_Id' => $data['areas']])->one();
            $mid = Yii::$app->user->identity->getId();
            $attributes = [
                'member_id' => $mid,
                'network_id' => $library->Network_Id,
                'network_name' => Network::GetNameById($library->Network_Id),
                'address_library_id' => $data['areas'],
                'address' => AddressLibrary::AddressString($data['areas']),
            ];
            $model->setAttributes($attributes);
            if($model->save()){
                if($model->is_default == 1){
                    AddressBook::updateAll(['is_default' => 0], ['member_id' => $mid, 'type' => $model->type]);
                }
                Yii::$app->session->setFlash('success', 'Add Success!');
                return $this->redirect(['/member/book']);
            }else{
                print_r($model->getErrors()); exit;
            }
        }else{
            return $this->render('add', [
                'model' => $model
            ]);
        }
    }

    public function actionGetRegion(){
        $country = Yii::$app->request->post('country');
        $regions = AddressLibrary::find()->where(['Country' => $country])->groupBy('Region1')->all();
        $options = '<option value="">Select a Region1</option>';
        if($regions){
            foreach($regions as $r){
                $options .= '<option value="'. $r->Region1 .'">'. $r->Region1 .'</option>';
            }
        }
        echo $options;
    }

    public function actionGetCode(){
        $country = Yii::$app->request->post('country');
        $region1 = Yii::$app->request->post('region1');
        $codes = AddressLibrary::find()->where(['Country' => $country, 'Region1' => $region1])->andwhere(['is not', 'Network_Id', null])->all();
        $options = '<option value="">Select a Area</option>';
        if($codes){
            foreach($codes as $c){
                $options .= '<option value="'. $c->Address_Library_Id .'">'. $c->Region2.' '.$c->Region3.' '.$c->Region4.' '.$c->Locality.' '.$c->Postcode .'</option>';
            }
        }
        echo $options;
    }

    public function actionModalCreate(){
        $model = new AddressBook();
        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('AddressBook');
            $library = AddressLibrary::find()->where(['Address_Library_Id' => $data['areas']])->one();
            $mid = Yii::$app->user->identity->getId();
            $attributes = [
                'member_id' => $mid,
                'network_id' => $library->Network_Id,
                'network_name' => Network::GetNameById($library->Network_Id),
                'address_library_id' => $data['areas'],
                'address' => AddressLibrary::AddressString($data['areas']),
            ];
            $model->setAttributes($attributes);
            if($model->save()){
                if($model->is_default == 1){
                    AddressBook::updateAll(['is_default' => 0], ['member_id' => $mid, 'type' => $model->type]);
                }
                $json = [
                    'id' => $model->primaryKey,
                    'type' => $model->type,
                    'address' => $model->address.' '.$model->gate
                ];
                exit(json_encode(['status' => true, 'data' => $json]));
            }else{
                exit(json_encode(['status' => false, 'msg' => $model->getErrors()]));
            }
        }else{
            $type = Yii::$app->request->get('type');
            $model->type = intval($type);
            return $this->renderAjax('modal', [
                'model' => $model,
            ]);
        }
    }
}