<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddressLibrarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-library-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Address_Library_Id') ?>

    <?= $form->field($model, 'ISO') ?>

    <?= $form->field($model, 'Country') ?>

    <?= $form->field($model, 'Language') ?>

    <?= $form->field($model, 'ID') ?>

    <?php // echo $form->field($model, 'Region1') ?>

    <?php // echo $form->field($model, 'Region2') ?>

    <?php // echo $form->field($model, 'Region3') ?>

    <?php // echo $form->field($model, 'Region4') ?>

    <?php // echo $form->field($model, 'Locality') ?>

    <?php // echo $form->field($model, 'Postcode') ?>

    <?php // echo $form->field($model, 'Suburb') ?>

    <?php // echo $form->field($model, 'Latitude') ?>

    <?php // echo $form->field($model, 'Longitude') ?>

    <?php // echo $form->field($model, 'Elevation') ?>

    <?php // echo $form->field($model, 'ISO2') ?>

    <?php // echo $form->field($model, 'FIPS') ?>

    <?php // echo $form->field($model, 'NUTS') ?>

    <?php // echo $form->field($model, 'HASC') ?>

    <?php // echo $form->field($model, 'STAT') ?>

    <?php // echo $form->field($model, 'Timezone') ?>

    <?php // echo $form->field($model, 'UTC') ?>

    <?php // echo $form->field($model, 'DST') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
