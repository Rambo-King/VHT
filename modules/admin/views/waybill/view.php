<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Waybill */

$this->title = $model->waybill_id;
$this->params['breadcrumbs'][] = ['label' => 'Waybills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="waybill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->waybill_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->waybill_id], [
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
            'waybill_id',
            'state',
            'waybill_number',
            'order_id',
            'order_number',
            'agent_number',
            'created_at',
        ],
    ]) ?>

</div>
