<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">

    <?php
    if(Yii::$app->session->hasFlash('success')){
        echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Member', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'member_id',
            'email',
            //'password',
            'account_number',
            'company_name',
            //'auth_key',
            //'access_token',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',

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
                //'options' => ['width' => '60'],
                'value' => function($m){
                        return Html::a("Change Password", \yii\helpers\Url::to(['/admin/member/password', 'id' => "{$m->member_id}"]), ["class" => "btn btn-success"]);
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
                $.post('/admin/member/ajax-delete', {'id':obj.getAttribute('data-id')}, function(bool){
                    if(bool){
                        window.location.href = '/admin/member';
                    }
                });
            },
            no:function(index){
                layer.close(index);
            }
        });
    }
</script>
