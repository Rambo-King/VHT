<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_number') ?>

    <?= $form->field($model, 'state') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'network_id') ?>

    <?php // echo $form->field($model, 'network_name') ?>

    <?php // echo $form->field($model, 'mailing_address_id') ?>

    <?php // echo $form->field($model, 'mailing_name') ?>

    <?php // echo $form->field($model, 'mailing_telephone') ?>

    <?php // echo $form->field($model, 'mailing_address') ?>

    <?php // echo $form->field($model, 'receiving_address_id') ?>

    <?php // echo $form->field($model, 'receiving_name') ?>

    <?php // echo $form->field($model, 'receiving_telephone') ?>

    <?php // echo $form->field($model, 'receiving_address') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
