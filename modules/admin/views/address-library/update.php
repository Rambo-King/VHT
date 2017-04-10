<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AddressLibrary */

$this->title = 'Update Address Library: ' . $model->Address_Library_Id;
$this->params['breadcrumbs'][] = ['label' => 'Address Libraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Address_Library_Id, 'url' => ['view', 'id' => $model->Address_Library_Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="address-library-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
