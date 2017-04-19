<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_product_id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_number') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'width') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'length_unit_id') ?>

    <?php // echo $form->field($model, 'length_unit_name') ?>

    <?php // echo $form->field($model, 'weight_unit_id') ?>

    <?php // echo $form->field($model, 'weight_unit_name') ?>

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
