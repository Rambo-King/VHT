<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Unit;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Units';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index">

    <?php
    if(Yii::$app->session->hasFlash('success')){
        echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Unit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'unit_id',
            [
                'attribute' => 'type',
                'filter' => Unit::UnitTypeList(),
                'value' => function($m){
                        return Unit::GetNameByType($m->type);
                    }
            ],
            'name',
            'description:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'headerOptions' => ['width' => '142'],
                'template' => '{update} {delete} {area}',
                'buttons' => [
                    'update' => function($url, $model, $key){
                            return Html::a("Modify", \yii\helpers\Url::to($url), ["class" => "btn btn-primary"]);
                        },
                    'delete' => function($url, $model, $key){
                            return '<a data-id="'.$key.'" onclick="DeleteConfirm(this);" href="javascript:;" class="btn btn-danger">Delete</a>';
                        },
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
            title:'温馨提示',
            content:'删除后不可恢复 请谨慎操作?',
            btn:['确定', '取消'],
            yes:function(){
                $.post('/admin/unit/ajax-delete', {'id':obj.getAttribute('data-id')}, function(bool){
                    if(bool){
                        window.location.href = '/admin/unit';
                    }
                });
            },
            no:function(index){
                layer.close(index);
            }
        });
    }
</script>

