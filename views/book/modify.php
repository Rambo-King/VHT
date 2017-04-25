<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddressBook */
?>
    <div class="content">
        <h1>ACCOUNT CENTER</h1>

        <div class="account-center">
            <?= $this->render('//member/menu') ?>

            <div class="main">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class'=>'form-horizontal',
                        'enctype' => 'multipart/form-data',
                    ],
                    'fieldConfig' => [
                        'template' => '{label}<div class="col-xs-4">{input}</div><div class="col-xs-5">{error}</div>',
                        'labelOptions' => ['class' => 'col-xs-3 control-label'],
                    ],
                ]); ?>
                <div class="field">
                    <span class="legend">Contact Information</span>
                    <div class="member-form form">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'fixed_line')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="field">
                    <span class="legend">Address</span>
                    <div class="member-form form">
                        <?= $form->field($model, 'type')->widget(kartik\select2\Select2::className(), [
                            'data' => \app\models\AddressBook::TypeList(),
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
                            'data' => \app\models\AddressLibrary::CodeList2($model->country, $model->region1),
                            'options' => ['placeholder' => 'Select a Area ...']
                        ]) ?>
                        <?= $form->field($model, 'gate')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'is_default')->widget(kartik\select2\Select2::className(), [
                            'data' => [0 => 'N', 1 => 'Y']
                        ]) ?>
                    </div>
                </div>
                <div class="buttons-set">
                    <a onclick="javascript:history.back(-1)" class="btn btn-success">Back</a>
                    <?= Html::submitButton('SAVE ADDRESS', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php
$this->registerCssFile('css/account.css', ['depends' => 'app\assets\AppAsset']);

$script = <<<JS
    $('#addressbook-country').change(function(){
        var country = $(this).val();
        $.post('/book/get-region', {'country':country}, function(html){
            $('#addressbook-region1').html('').append(html);
        });
    });
    $('#addressbook-region1').change(function(){
        var country = $('#addressbook-country').val();
        var region1 = $(this).val();
        $.post('/book/get-code', {'country':country, 'region1':region1}, function(html){
            $('#addressbook-areas').html('').append(html);
        });
    });
JS;
$this->registerJs($script);
?>