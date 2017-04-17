<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\NetworkArea */

$this->title = 'Create Network Area';
$this->params['breadcrumbs'][] = ['label' => 'Network Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-area-create">

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
    $('#networkarea-country').change(function(){
        if($('#networkarea-network_id').val() == ''){
            $('#networkarea-network_id').parent().siblings('.col-xs-3').find('.help-block').html('Please Select a Network').css({'color':'#a94442'})
        }
        var country = $(this).val();
        $.post('/admin/network/get-region', {'country':country}, function(html){
            $('#networkarea-region1').html('').append(html);
        });
    });
    $('#networkarea-region1').change(function(){
        var network = $('#networkarea-network_id').val();
        var country = $('#networkarea-country').val();
        var region1 = $(this).val();
        $.post('/admin/network-area/get-code', {'networkId':network, 'country':country, 'region1':region1}, function(html){
            $('#networkarea-areas').html('').append(html);
        });
    });
JS;
$this->registerJs($script);
?>