<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Network;
use Yii;
use app\models\AddressBook;
use app\models\AddressBookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AddressLibrary;

/**
 * AddressBookController implements the CRUD actions for AddressBook model.
 */
class AddressBookController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'user' => 'admin',
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'get-region', 'get-code', 'ajax-delete'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * Lists all AddressBook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AddressBookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AddressBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AddressBook();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('AddressBook');
            $library = AddressLibrary::find()->where(['Address_Library_Id' => $data['areas']])->one();
            $attributes = [
                'network_id' => $library->Network_Id,
                'network_name' => Network::GetNameById($library->Network_Id),
                'address_library_id' => $data['areas'],
                'address' => AddressLibrary::AddressString($data['areas']),
                'created_by' => Yii::$app->admin->getId(),
            ];
            $model->setAttributes($attributes);
            if($model->save()){
                if($model->is_default == 1){
                    AddressBook::updateAll(['is_default' => 0], ['member_id' => $model->member_id, 'type' => $model->type]);
                }
                Yii::$app->session->setFlash('success', 'Create Success!');
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
     * Updates an existing AddressBook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('AddressBook');
            $library = AddressLibrary::find()->where(['Address_Library_Id' => $data['areas']])->one();
            $attributes = [
                'network_id' => $library->Network_Id,
                'network_name' => Network::GetNameById($library->Network_Id),
                'address_library_id' => $data['areas'],
                'address' => AddressLibrary::AddressString($data['areas']),
                'updated_by' => Yii::$app->admin->getId(),
            ];
            $model->setAttributes($attributes);
            if($model->save()){
                if($model->is_default == 1){
                    AddressBook::updateAll(['is_default' => 0], ['member_id' => $model->member_id, 'type' => $model->type]);
                }
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
     * Deletes an existing AddressBook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AddressBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AddressBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AddressBook::findOne($id)) !== null) {
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
        $codes = AddressLibrary::find()->where(['Country' => $country, 'Region1' => $region1])->andwhere(['is not', 'Network_Id', null])->all();
        $options = '<option value="">Select a Area</option>';
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
            Yii::$app->session->setFlash('success', 'Delete Success!');
        }else{
            Yii::$app->session->setFlash('success', 'Delete Failure!');
        }
        exit(true);
    }

}
