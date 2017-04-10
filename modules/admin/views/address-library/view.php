<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AddressLibrary */

$this->title = $model->Address_Library_Id;
$this->params['breadcrumbs'][] = ['label' => 'Address Libraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-library-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Address_Library_Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Address_Library_Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Address_Library_Id',
            'ISO',
            'Country',
            'Language',
            'ID',
            'Region1',
            'Region2',
            'Region3',
            'Region4',
            'Locality',
            'Postcode',
            'Suburb',
            'Latitude',
            'Longitude',
            'Elevation',
            'ISO2',
            'FIPS',
            'NUTS',
            'HASC',
            'STAT',
            'Timezone',
            'UTC',
            'DST',
        ],
    ]) ?>

</div>
