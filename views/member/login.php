<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Member Login';
?>

<div class="member-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="member-login-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class'=>'form-horizontal',
                'enctype' => 'multipart/form-data',
            ],
            'fieldConfig' => [
                'template' => '{label}<div class="col-xs-6">{input}</div><div class="col-xs-4">{error}</div>',
                'labelOptions' => ['class' => 'col-xs-2 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-xs-2 col-xs-offset-2">
                <?= Html::submitButton('Login', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Register', ['register'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
