<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Member */

$this->title = 'Update Member: ' . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="member-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="member-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class'=>'form-horizontal',
                'enctype' => 'multipart/form-data',
            ],
            'fieldConfig' => [
                'template' => '{label}<div class="col-xs-4">{input}</div><div class="col-xs-5">{error}</div>',
                'labelOptions' => ['class' => 'col-xs-2 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'password3')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password4')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <div class="col-xs-2 col-xs-offset-2">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
