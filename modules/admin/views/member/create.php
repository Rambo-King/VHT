<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Member */

$this->title = 'Create Member';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="member-form">

        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'options' => [
                'class'=>'form-horizontal',
                'enctype' => 'multipart/form-data',
            ],
            'fieldConfig' => [
                'template' => '{label}<div class="col-xs-4">{input}</div><div class="col-xs-5">{error}</div>',
                'labelOptions' => ['class' => 'col-xs-2 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password2')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <div class="col-xs-2 col-xs-offset-2">
                <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
