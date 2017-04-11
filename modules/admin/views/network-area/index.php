<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\NetworkAreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Network Jurisdiction Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-area-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Network Area', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'network_area_id',
            'network_id',
            'country',
            'code',
            'address_string',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'headerOptions' => ['width' => '197'],
                'template' => '{update} {delete} {area}',
                'buttons' => [
                    'update' => function($url, $model, $key){
                            return Html::a("Modify", \yii\helpers\Url::to([$url, 'id' => "$key"]), ["class" => "btn btn-primary"]);
                        },
                    'delete' => function($url, $model, $key){
                            return '<a data-id="'.$key.'" onclick="DeleteConfirm(this);" href="javascript:;" class="btn btn-warning">Delete</a>';
                        },
                    'area' => function($url, $model, $key){
                            return Html::a("Area", \yii\helpers\Url::to(['', 'id' => "$key"]), ["class" => "btn btn-success"]);
                        }
                ],
            ],
        ],
    ]); ?>
</div>
