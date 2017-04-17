<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddressBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-book-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class'=>'form-horizontal',
            'enctype' => 'multipart/form-data',
        ],
        'fieldConfig' => [
            'template' => '{label}<div class="col-xs-6">{input}</div><div class="col-xs-2">{error}</div>',
            'labelOptions' => ['class' => 'col-xs-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'member_id')->widget(kartik\select2\Select2::className(), [
        'data' => \app\models\Member::MemberList(),
        'options' => ['placeholder' => 'Select a Member ...']
    ]) ?>

    <?= $form->field($model, 'type')->widget(kartik\select2\Select2::className(), [
        'data' => \app\models\AddressBook::TypeList(),
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fixed_line')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->widget(kartik\select2\Select2::className(), [
        'data' => \app\models\AddressLibrary::CountryList(),
        'options' => ['placeholder' => 'Select a Country ...']
    ]) ?>

    <?= $form->field($model, 'region1')->widget(kartik\select2\Select2::className(), [
        'options' => ['placeholder' => 'Select a Region1 ...']
    ]) ?>

    <?= $form->field($model, 'areas')->widget(kartik\select2\Select2::className(), [
        'options' => ['placeholder' => 'Select a Area ...']
    ]) ?>

    <?= $form->field($model, 'gate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_default')->widget(kartik\select2\Select2::className(), [
        'data' => [0 => 'N', 1 => 'Y']
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2 col-xs-offset-2">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
    $('#addressbook-country').change(function(){
        var country = $(this).val();
        $.post('/admin/address-book/get-region', {'country':country}, function(html){
            $('#addressbook-region1').html('').append(html);
        });
    });
    $('#addressbook-region1').change(function(){
        var country = $('#addressbook-country').val();
        var region1 = $(this).val();
        $.post('/admin/address-book/get-code', {'country':country, 'region1':region1}, function(html){
            $('#addressbook-areas').html('').append(html);
        });
    });
JS;
$this->registerJs($script);
?>
