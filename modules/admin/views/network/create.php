<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Network */

$this->title = 'Create Network';
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="network-form">

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

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

        <?= $form->field($model, 'country')->widget(kartik\select2\Select2::className(), [
            'data' => \app\models\AddressLibrary::CountryList(),
            'options' => ['placeholder' => 'Select a Country ...']
        ]) ?>

        <?= $form->field($model, 'region1')->widget(kartik\select2\Select2::className(), [
            'options' => ['placeholder' => 'Select a Region1 ...']
        ]) ?>

        <?= $form->field($model, 'areas')->widget(kartik\select2\Select2::className(), [
            'options' => ['placeholder' => 'Select Areas ...', 'multiple' => true]
        ]) ?>

        <div class="form-group">
            <div class="col-xs-2 col-xs-offset-2">
                <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php
$script = <<<JS
    $('#network-country').change(function(){
        var country = $(this).val();
        $.post('/admin/network/get-region', {'country':country}, function(html){
            $('#network-region1').html('').append(html);
        });
    });
    $('#network-region1').change(function(){
        var country = $('#network-country').val();
        var region1 = $(this).val();
        $.post('/admin/network/get-code', {'country':country, 'region1':region1}, function(html){
            $('#network-areas').html('').append(html);
        });
    });
JS;
$this->registerJs($script);
?>