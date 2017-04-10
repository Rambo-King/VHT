<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddressLibrary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-library-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ISO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Region1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Region2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Region3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Region4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Locality')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Suburb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Latitude')->textInput() ?>

    <?= $form->field($model, 'Longitude')->textInput() ?>

    <?= $form->field($model, 'Elevation')->textInput() ?>

    <?= $form->field($model, 'ISO2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FIPS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NUTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HASC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Timezone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UTC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DST')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
