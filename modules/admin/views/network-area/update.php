<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\NetworkArea */

$this->title = 'Update Network Area: ' . $model->network_area_id;
$this->params['breadcrumbs'][] = ['label' => 'Network Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="network-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="network-area-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class'=>'form-horizontal',
                'enctype' => 'multipart/form-data',
            ],
            'fieldConfig' => [
                'template' => '{label}<div class="col-xs-6">{input}</div><div class="col-xs-3">{error}</div>',
                'labelOptions' => ['class' => 'col-xs-2 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'network_id')->widget(kartik\select2\Select2::className(), [
            'data' => \app\modules\admin\models\Network::NetworkList(),
            'options' => ['placeholder' => 'Select a Network ...']
        ]) ?>

        <?= $form->field($model, 'country')->widget(kartik\select2\Select2::className(), [
            'data' => \app\models\AddressLibrary::CountryList(),
            'options' => ['placeholder' => 'Select a Country ...']
        ]) ?>

        <?= $form->field($model, 'region1')->widget(kartik\select2\Select2::className(), [
            'data' => \app\models\AddressLibrary::Region1List($model->country),
            'options' => ['placeholder' => 'Select a Region1 ...']
        ]) ?>

        <?= $form->field($model, 'areas')->widget(kartik\select2\Select2::className(), [
            'data' => \app\models\AddressLibrary::CodeList($model->network_id, $model->address_library_id, $model->country, $model->region1),
            'options' => ['placeholder' => 'Select a Area ...']
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
    $('#networkarea-country').change(function(){
        $('#networkarea-areas').html('').append('<option value="">Select a Area ...</option>');
        var country = $(this).val();
        $.post('/admin/network-area/get-region', {'country':country}, function(html){
            $('#networkarea-region1').html('').append(html);
        });
    });
    $('#networkarea-region1').change(function(){
        var country = $('#networkarea-country').val();
        var region1 = $(this).val();
        $.post('/admin/network-area/get-code', {'country':country, 'region1':region1}, function(html){
            $('#networkarea-areas').html('').append(html);
        });
    });
JS;
$this->registerJs($script);
?>
