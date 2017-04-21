<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Account Information ';
?>
    <div class="content">
        <h1>ACCOUNT CENTER</h1>

        <div class="account-center">
            <?/*= $this->render('//member/menu') */?>
            <?= $this->render('menu') ?>

            <div class="main">
                <?php
                if(Yii::$app->session->hasFlash('success')){
                    echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
                }
                ?>

                <?php $form = ActiveForm::begin([
                    'enableAjaxValidation' => true,
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
                        <span class="legend">Account Information</span>
                        <div class="member-form form">
                            <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="buttons-set">
                        <a onclick="javascript:history.back(-1)" class="btn btn-success">Back</a>
                        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerCssFile('css/account.css', ['depends' => 'app\assets\AppAsset']);
?>