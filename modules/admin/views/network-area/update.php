<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\NetworkArea */

$this->title = 'Update Network Area: ' . $model->network_area_id;
$this->params['breadcrumbs'][] = ['label' => 'Network Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->network_area_id, 'url' => ['view', 'id' => $model->network_area_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="network-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
