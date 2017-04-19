<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Order Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_product_id',
            'order_id',
            'order_number',
            'name',
            'description:ntext',
            // 'quantity',
            // 'length',
            // 'width',
            // 'height',
            // 'weight',
            // 'length_unit_id',
            // 'length_unit_name',
            // 'weight_unit_id',
            // 'weight_unit_name',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
