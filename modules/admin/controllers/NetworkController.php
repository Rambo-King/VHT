<?php

namespace app\modules\admin\controllers;

use app\models\AddressLibrary;
use app\modules\admin\models\NetworkArea;
use Yii;
use app\modules\admin\models\Network;
use app\modules\admin\models\NetworkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NetworkController implements the CRUD actions for Network model.
 */
class NetworkController extends Controller
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
     * Lists all Network models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NetworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Network model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new Network();
        $model->setScenario('create');

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = 1; //Yii session data
            if($model->save()){
                $networkAreaModel = new NetworkArea();
                $networkAreaModel->country = $networkAreaModel->region1 = $networkAreaModel->areas = 0;
                $data = Yii::$app->request->post('Network');
                foreach($data['areas'] as $aid){
                    $naModel = clone $networkAreaModel;
                    $m = AddressLibrary::find()->where(['Address_Library_Id' => $aid])->one();
                    $attributes = [
                        'network_id' => $model->primaryKey,
                        'address_library_id' => $aid,
                        'address' => $m->Country.' '.$m->Region1.' '.$m->Region2.' '.$m->Region3.' '.$m->Region4.' '.$m->Locality.' '.$m->Postcode,
                        'created_by' => 1, //Yii session data
                    ];
                    $naModel->setAttributes($attributes);
                    if($naModel->save()){
                        $m->Network_Id = $model->primaryKey;
                        $m->save();
                    }else{
                        print_r($naModel->getErrors());exit;
                    }
                }
                return $this->redirect(['index']);
            }else{
                print_r($model->getErrors()); exit;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Network model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = 2;
            if($model->save())
                return $this->redirect(['index']);
            else{
                print_r($model->getErrors()); exit;
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Network model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Network the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Network::findOne($id)) !== null) {
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
        $country = Yii::$app->request->post('country');
        $region1 = Yii::$app->request->post('region1');
        $codes = AddressLibrary::find()->where(['Country' => $country, 'Region1' => $region1, 'Network_Id' => null])->all();
        $options = '<option value="">Select a Region1</option>';
        if($codes){
            foreach($codes as $c){
                $options .= '<option value="'. $c->Address_Library_Id .'">'. $c->Region2.' '.$c->Region3.' '.$c->Region4.' '.$c->Locality.' '.$c->Postcode .'</option>';
            }
        }
        echo $options;
    }

    public function actionAjaxDelete(){
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        if($model->delete()){
            $rows = NetworkArea::find()->select('address_library_id')->where(['network_id' => $id])->all();
            NetworkArea::deleteAll(['network_id' => $id]);

            $primaryArr = [];
            foreach($rows as $r) $primaryArr[] = $r->address_library_id;
            AddressLibrary::updateAll(['Network_Id' => null], ['in', 'Address_Library_Id', $primaryArr]);

            Yii::$app->session->setFlash('success', 'Delete Success!');
        }

        exit(true);
    }

}
