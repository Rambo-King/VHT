<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProduct */

$this->title = 'Update Order Product: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Order Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->order_product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
