<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Waybill */

$this->title = 'Update Waybill: ' . $model->waybill_id;
$this->params['breadcrumbs'][] = ['label' => 'Waybills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->waybill_id, 'url' => ['view', 'id' => $model->waybill_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="waybill-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
