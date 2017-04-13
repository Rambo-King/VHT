<?php

namespace app\modules\admin\controllers;

use app\models\AddressLibrary;
use Yii;
use app\modules\admin\models\NetworkArea;
use app\modules\admin\models\NetworkAreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NetworkAreaController implements the CRUD actions for NetworkArea model.
 */
class NetworkAreaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all NetworkArea models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $searchModel = new NetworkAreaSearch();
        $queryParams = Yii::$app->request->queryParams;
        if(!is_null($id)){
            $searchParams['NetworkAreaSearch'] = ['network_id' => $id];
            $queryParams = array_merge($queryParams, $searchParams);
        }
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new NetworkArea model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NetworkArea();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('NetworkArea');
            foreach($data['areas'] as $aid){
                $naModel = clone $model;
                $m = AddressLibrary::find()->where(['Address_Library_Id' => $aid])->one();
                $attributes = [
                    'address_library_id' => $aid,
                    'address' => $m->Country.' '.$m->Region1.' '.$m->Region2.' '.$m->Region3.' '.$m->Region4.' '.$m->Locality.' '.$m->Postcode,
                    'created_by' => 1, //Yii session data
                ];
                $naModel->setAttributes($attributes);
                if($naModel->save()){
                    $m->Network_Id = $model->network_id;
                    $m->save();
                }else{
                    print_r($naModel->getErrors()); exit;
                }
            }
            Yii::$app->session->setFlash('success', 'Create Success!');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NetworkArea model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = 2;
            if($model->save()){
                $m = AddressLibrary::find()->where(['Address_Library_Id' => $model->address_library_id])->one();
                $m->Network_Id = $model->network_id;
                $m->save();
                Yii::$app->session->setFlash('success', 'Update Success!');
                return $this->redirect(['index']);
            }else{
                print_r($model->getErrors()); exit;
            }
        } else {
            $library = AddressLibrary::find()->where(['Address_Library_Id' => $model->address_library_id])->one();
            $model->country = $library->Country;
            $model->region1 = $library->Region1;
            $model->areas = $library->Address_Library_Id;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the NetworkArea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NetworkArea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NetworkArea::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
        $networkId = Yii::$app->request->post('networkId');
        $records = NetworkArea::GetCodesByNetworkId($networkId);
        $country = Yii::$app->request->post('country');
        $region1 = Yii::$app->request->post('region1');
        $codes = AddressLibrary::find()->where(['Country' => $country, 'Region1' => $region1])->all();
        $options = '<option value="">Select a Region1</option>';
        if($codes){
            foreach($codes as $c){
                if(in_array($c->Address_Library_Id, $records)) continue;
                $options .= '<option value="'. $c->Address_Library_Id .'">'. $c->Region2.' '.$c->Region3.' '.$c->Region4.' '.$c->Locality.' '.$c->Postcode .'</option>';
            }
        }
        echo $options;
    }

    public function actionAjaxDelete(){
        $data = ['state' => false, 'msg' => null];
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        if($model->delete()){
            $m = AddressLibrary::find()->where(['Address_Library_Id' => $model->address_library_id])->one();
            $m->Network_Id = null;
            if($m->save()){
                $data['state'] = true;
                Yii::$app->session->setFlash('success', 'Delete Success!');
            }
        }

        exit(json_encode($data));
    }

    public function actionBatchDelete(){
        $keyStr = Yii::$app->request->post('keyStr');
        $keyArr = explode(',', $keyStr);

        $rows = NetworkArea::find()->select(['address_library_id'])->where(['in', 'network_area_id', $keyArr])->all();
        NetworkArea::deleteAll(['in', 'network_area_id', $keyArr]);

        $primaryArr = [];
        foreach($rows as $r) $primaryArr[] = $r->address_library_id;
        AddressLibrary::updateAll(['Network_Id' => null], ['in', 'Address_Library_Id', $primaryArr]);

        Yii::$app->session->setFlash('success', 'Batch Delete Success!');
        exit(true);
    }

}
