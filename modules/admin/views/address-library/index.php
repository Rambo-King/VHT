<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AddressLibrarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Address Libraries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-library-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'Address_Library_Id',
            'ISO',
            'Country',
            'Postcode',
            'Language',
            'ID',
            'Region1',
            'Region2',
            'Region3',
            'Region4',
            'Locality',
            'Latitude',
            'Longitude',
            /*'Suburb',
            'Elevation',
            'ISO2',
            'FIPS',
            'NUTS',
            'HASC',
            'STAT',
            'Timezone',
            'UTC',
            'DST',*/

        ],
    ]); ?>
</div>
