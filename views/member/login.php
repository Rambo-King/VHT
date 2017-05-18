<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

$this->title = 'Member Login';
?>

<div class="site-login">
    <div class="container">

        <div class="jumbotron">
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

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email / Account Number', 'autocomplete' => 'off']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>

            <div class="form-group">
                <div class="col-sm-12">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-success btn-lg btn-block', 'name' => 'login-button']) ?>
                    <?= Html::a('Register', ['register'], ['class' => 'btn btn-success btn-lg btn-block']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

<?php
$this->registerCssFile('css/login.css', ['depends' => 'app\assets\AppAsset']);
$script = <<<JS
    $('#memberloginform-email').focus(function(){
        $('#memberloginform-password').val('');
    });
JS;
$this->registerJs($script);
?>