<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Network;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\NetworkAreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Network Jurisdiction Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-area-index">

    <?php
    if(Yii::$app->session->hasFlash('success')){
        echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Network Area', ['create'], ['class' => 'btn btn-success']) ?>
        <a href="javascript:AjaxBatchDel();" class="btn btn-danger">Batch Delete</a>
    </p>
    <?= GridView::widget([
        'id' => 'Network-Area-Grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'network_area_id',
            [
                'attribute' => 'network_id',
                'filter' => Network::NetworkList(),
                'value' => function($m){
                        return Network::GetNameById($m->network_id);
                    }
            ],
            'address',
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
                        }
                ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
    function DeleteConfirm(obj){
        layer.open({
            //skin: 'layui-layer-molv',
            skin: 'layui-layer-lan',
            shift: 1,
            title:'温馨提示',
            content:'删除后不可恢复 请谨慎操作?',
            btn:['确定', '取消'],
            yes:function(){
                $.post('/admin/network-area/ajax-delete', {'id':obj.getAttribute('data-id')}, function(json){
                    if(json.state){
                        window.location.href = '/admin/network-area';
                    }
                }, 'json');
            },
            no:function(index){
                layer.close(index);
            }
        });
    }
    function AjaxBatchDel(){
        var keys = $('#Network-Area-Grid').yiiGridView('getSelectedRows');
        if(keys.length){
            layer.open({
                skin: 'layui-layer-lan',
                shift: 1,
                title:'温馨提示',
                content:'批量删除后不可恢复 请谨慎操作?',
                btn:['确定', '取消'],
                yes:function (index) {
                    var keyStr = keys.join(',');
                    $.post('/admin/network-area/batch-delete', {'keyStr':keyStr}, function(bool){
                        if(bool){
                            /*layer.open({
                                skin: 'layui-layer-lan',
                                shift: 1,
                                title:'温馨提示',
                                content:'删除成功',
                                btn:['确定'],
                                yes:function (index) {
                                    layer.close(index);
                                    window.location.href = '/admin/network-area';
                                }
                            });*/
                            //window.location.href = '/admin/network-area';
                        }
                    });
                },
                no:function(index){
                    layer.close(index);
                }
            });
        }else{
            layer.open({
                skin: 'layui-layer-lan',
                shift: 1,
                title:'温馨提示',
                content:'请选择要删除的项',
                btn:['确定'],
                yes:function (index) {
                    layer.close(index);
                }
            });
        }
    }
</script>
