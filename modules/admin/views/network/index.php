<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\NetworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Networks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-index">

    <?php
    if(Yii::$app->session->hasFlash('success')){
        echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Network', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'network_id',
            'name',
            'description:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'headerOptions' => ['width' => '197'],
                'template' => '{update} {delete} {area}',
                'buttons' => [
                    'update' => function($url, $model, $key){
                            return Html::a("Modify", \yii\helpers\Url::to($url), ["class" => "btn btn-primary"]);
                        },
                    'delete' => function($url, $model, $key){
                            return '<a data-id="'.$key.'" onclick="DeleteConfirm(this);" href="javascript:;" class="btn btn-danger">Delete</a>';
                        },
                    'area' => function($url, $model, $key){
                            return Html::a("Area", \yii\helpers\Url::to(['/admin/network-area/index', 'id' => "$key"]), ["class" => "btn btn-success"]);
                        }
                ],
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
                $.post('/admin/network/ajax-delete', {'id':obj.getAttribute('data-id')}, function(bool){
                    if(bool){
                        window.location.href = '/admin/network';
                    }
                });
            },
            no:function(index){
                layer.close(index);
            }
        });
    }
</script>
