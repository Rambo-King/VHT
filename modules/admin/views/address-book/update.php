<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddressBook */

$this->title = 'Update Address Book: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Address Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->address_book_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="address-book-update">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'data' => \app\models\AddressLibrary::Region1List($model->country),
            'options' => ['placeholder' => 'Select a Region1 ...']
        ]) ?>

        <?= $form->field($model, 'areas')->widget(kartik\select2\Select2::className(), [
            'data' => \app\models\AddressLibrary::CodeList2($model->country, $model->region1),
            'options' => ['placeholder' => 'Select a Area ...']
        ]) ?>

        <?= $form->field($model, 'gate')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'is_default')->widget(kartik\select2\Select2::className(), [
            'data' => [0 => 'N', 1 => 'Y']
        ]) ?>

        <div class="form-group">
            <div class="col-xs-2 col-xs-offset-2">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
$script = <<<JS
    $('#addressbook-country').change(function(){
        $('#addressbook-areas').html('').append('<option value="">Select a Area ...</option>');
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