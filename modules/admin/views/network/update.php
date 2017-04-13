<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Network */

$this->title = 'Update Network: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="network-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="network-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class'=>'form-horizontal',
                'enctype' => 'multipart/form-data',
            ],
            'fieldConfig' => [
                'template' => '{label}<div class="col-xs-6">{input}</div><div class="col-xs-3">{error}</div>',
                'labelOptions' => ['class' => 'col-xs-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

        <div class="form-group">
            <div class="col-xs-1 col-xs-offset-1">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
