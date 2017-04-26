<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Managers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-index">

    <?php
    if(Yii::$app->session->hasFlash('success')){
        echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Manager', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'manager_id',
            [
                'attribute' => 'role_id',
                'filter' => \app\modules\admin\models\Manager::Roles(),
                'value' => function($m){
                        return \app\modules\admin\models\Manager::GetRole($m->role_id);
                    }
            ],
            'username',
            //'password',
            //'auth_key',
            //'access_token',
            'account_name',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'created_by',
                'filter' => \app\modules\admin\models\Manager::ManagerList(),
                'value' => function($m){
                        return \app\modules\admin\models\Manager::GetAccountName($m->created_by);
                    }
            ],
            [
                'attribute' => 'updated_by',
                'filter' => \app\modules\admin\models\Manager::ManagerList(),
                'value' => function($m){
                        return \app\modules\admin\models\Manager::GetAccountName($m->updated_by);
                    }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'headerOptions' => ['width' => '142'],
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key){
                            return Html::a("Modify", \yii\helpers\Url::to($url), ["class" => "btn btn-primary"]);
                        },
                    'delete' => function($url, $model, $key){
                            return '<a data-id="'.$key.'" onclick="DeleteConfirm(this);" href="javascript:;" class="btn btn-danger">Delete</a>';
                        },
                ],
            ],
            [
                'label' => 'Other',
                'format' => 'raw',
                'value' => function($m){
                        return Html::a("Change Password", \yii\helpers\Url::to(['/admin/manager/password', 'id' => "{$m->manager_id}"]), ["class" => "btn btn-success"]);
                    }
            ],
        ],
    ]); ?>
</div>

<script type="text/javascript">
    function DeleteConfirm(obj){
        layer.open({
            skin: 'layui-layer-lan',
            shift: 1,
            title:'Kindly Reminder',
            content:'Please be careful not to resume after deletion ?',
            btn:['Confirm', 'Cancel'],
            yes:function(){
                $.post('/admin/manager/ajax-delete', {'id':obj.getAttribute('data-id')}, function(bool){
                    if(bool){
                        window.location.href = '/admin/manager';
                    }
                });
            },
            no:function(index){
                layer.close(index);
            }
        });
    }
</script>
