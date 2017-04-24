<?php
namespace app\controllers;

use app\components\Paging;
use app\models\AddressBook;
use app\models\Member;
use app\models\MemberLoginForm;
use app\models\MemberRegisterForm;
use app\models\Order;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class MemberController extends Controller{

    //public $defaultAction = 'login';
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => 'user',
                'rules' => [
                    [
                        'actions' => ['logout', 'account', 'information', 'password', 'order', 'book'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register', 'login'],
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

    private function MemberLoginId(){
        return Yii::$app->user->identity->member_id;
    }

    public function actionRegister(){
        $model = new MemberRegisterForm();
        if($model->load(Yii::$app->request->post()) && $member = $model->Register()){
            Yii::$app->getUser()->login($member);
            return $this->goHome();
        }else{
            return $this->render('register', ['model' => $model]);
        }
    }

    public function actionLogin(){
        $model = new MemberLoginForm();
        if($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->goBack();
        }else{
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionAccount(){
        //Yii::$app->user->identity->email
        $member = $this->findModel($this->MemberLoginId());
        $conditions = [
            'member_id' => $this->MemberLoginId()
        ];
        $orders = Order::find()->where($conditions)->limit(2)->orderBy('created_at desc')->all();

        $mailing = $receiving = null;
        $books = AddressBook::find()->where(['member_id' => $this->MemberLoginId(), 'is_default' => 1])->all();
        if($books){
            foreach($books as $book){
                if($book->type == 1) $mailing = $book;
                else if($book->type == 2) $receiving = $book;
            }
        }

        return $this->render('account', [
            'member' => $member,
            'orders' => $orders,
            'mailing' => $mailing,
            'receiving' => $receiving,
        ]);
    }

    /**
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInformation(){
        $model = $this->findModel($this->MemberLoginId());
        $model->setScenario('update');

        if((Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = 0;
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Update Success!');
                return $this->refresh();
            }else{
                print_r($model->getErrors()); exit();
            }
        } else {
            return $this->render('information', [
                'model' => $model,
            ]);
        }

    }

    public function actionPassword(){
        $model = $this->findModel($this->MemberLoginId());
        $model->setScenario('change');

        if($model->load(Yii::$app->request->post())){
            $data = Yii::$app->request->post('Member');
            $model->password = Yii::$app->security->generatePasswordHash($data['password3']);
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Password Changed Success!');
                return $this->refresh();
            }else{
                print_r($model->getErrors()); exit();
            }
        }else{
            return $this->render('password', [
                'model' => $model,
            ]);
        }
    }

    public function actionBook(){
        $mailing = $receiving = null;
        $default = AddressBook::find()->where(['member_id' => $this->MemberLoginId(), 'is_default' => 1])->all();
        if($default){
            foreach($default as $book){
                if($book->type == 1) $mailing = $book;
                else if($book->type == 2) $receiving = $book;
            }
        }
        $books = AddressBook::find()->where(['member_id' => $this->MemberLoginId(), 'is_default' => 0])->all();

        return $this->render('book', [
            'mailing' => $mailing,
            'receiving' => $receiving,
            'books' => $books,
        ]);
    }

    public function actionOrder(){
        $count = Order::find()->where(['member_id' => $this->MemberLoginId()])->count();
        $page = new Paging($count, 2);
        $sql = "select * from {{%order}} where member_id = {$this->MemberLoginId()} ".$page->limit;
        $orders = Order::findBySql($sql)->all();
        $plist = $page->fpage(array(0,1,2,3,4,5,6,7));

        return $this->render('order', [
            'orders' => $orders,
            'plist' => $plist,
        ]);
    }

}