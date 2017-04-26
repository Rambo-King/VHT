<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'VHT EXPRESS MANAGEMENT';
?>
<div class="site-login">
    <div class="container">

        <div class="jumbotron">
            <h1>Welcome</h1>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>

        <div class="login-form center-block">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{beginWrapper}\n{input}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'wrapper' => 'col-sm-12',
                        'offset' => '',
                    ],
                ],
                'errorCssClass' => '',
                'successCssClass' => 'has-success',
            ]); ?>

            <?= $form->errorSummary($model, ['header' => '']) ?>

            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username', 'autocomplete' => 'off']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>

            <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'form-group verifycode']])->widget(\yii\captcha\Captcha::className(), [
                'captchaAction' => 'manager/captcha',
                'template' => '{input} {image}',
                'options' => ['class' => 'form-control', 'placeholder' => 'Entry Verify Code' ],
            ]) ?>

            <div class="form-group">
                <div class="col-sm-12">
                    <?= Html::submitButton('Login Now', ['class' => 'btn btn-success btn-lg btn-block', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

<?php
$script = <<<JS
    $('#managerloginform-username').focus(function(){
        $('#managerloginform-password').val('');
    });
JS;
$this->registerJs($script);
?>
