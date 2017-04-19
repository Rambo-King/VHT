<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProduct */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Order Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_product_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_product_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_product_id',
            'order_id',
            'order_number',
            'name',
            'description:ntext',
            'quantity',
            'length',
            'width',
            'height',
            'weight',
            'length_unit_id',
            'length_unit_name',
            'weight_unit_id',
            'weight_unit_name',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
