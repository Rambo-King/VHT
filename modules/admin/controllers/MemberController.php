<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Member;
use app\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'password', 'ajax-delete'],
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
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new Member();
        $model->scenarios('add');

        if((Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = Yii::$app->admin->getId();
            $model->account_number = $model->account_number == '' ? null : $model->account_number;
            $model->password = $model->password2 = Yii::$app->security->generatePasswordHash($model->password);
            if($model->save()){
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
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');

        if((Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = Yii::$app->admin->getId();
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Update Success!');
                return $this->redirect(['index']);
            }else{
                print_r($model->getErrors()); exit();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPassword($id){
        $model = $this->findModel($id);
        $model->setScenario('change');

        if($model->load(Yii::$app->request->post())){
            $data = Yii::$app->request->post('Member');
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

    public function actionAjaxDelete(){
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Delete Success!');
        exit(true);
    }

}
