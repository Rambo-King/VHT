<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\ManagerLoginForm;
use Yii;
use app\modules\admin\models\Manager;
use app\modules\admin\models\ManagerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ManagerController implements the CRUD actions for Manager model.
 */
class ManagerController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'ajax-delete', 'password', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'captcha'],
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

    /**
     * Lists all Manager models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Manager model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Manager model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manager();
        $model->setScenario('add');

        if((Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->Add()) {
            Yii::$app->session->setFlash('success', 'Create Success!');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Manager model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('modify');

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Update Success!');
                return $this->redirect(['index']);
            }else{
                print_r($model->getErrors()); exit;
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Manager model.
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
     * Finds the Manager model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Manager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manager::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAjaxDelete(){
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Delete Success!');
        exit(true);
    }

    public function actionPassword($id){
        $model = $this->findModel($id);
        $model->setScenario('change');

        if($model->load(Yii::$app->request->post())){
            $data = Yii::$app->request->post('Manager');
            $model->password = Yii::$app->security->generatePasswordHash($data['password3']);
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Password Changed Success!');
                return $this->redirect(['index']);
            }else{
                print_r($model->getErrors()); exit();
            }
        }else{
            return $this->render('password', [
                'model' => $model,
            ]);
        }
    }

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 130,
                'height' => 50,
                'backColor' => 0xafdfe4,
                'foreColor' => 0x000000,
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 8,
            ],
        ];
    }

    public function actionLogin(){
        /*if(!Yii::$app->admin->isGuest){
            return $this->redirect('/admin');
        }*/
        $this->layout = 'login';
        $model = new ManagerLoginForm();

        if($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->redirect('/admin');
        }else{
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout(){
        Yii::$app->admin->logout(false);
        return $this->redirect('/admin/manager/login');
    }

}
