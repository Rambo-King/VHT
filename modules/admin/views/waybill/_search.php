<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WaybillSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="waybill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'waybill_id') ?>

    <?= $form->field($model, 'state') ?>

    <?= $form->field($model, 'waybill_number') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_number') ?>

    <?php // echo $form->field($model, 'agent_number') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
