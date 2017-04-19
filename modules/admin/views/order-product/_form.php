<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'length')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'length_unit_id')->textInput() ?>

    <?= $form->field($model, 'length_unit_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight_unit_id')->textInput() ?>

    <?= $form->field($model, 'weight_unit_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
