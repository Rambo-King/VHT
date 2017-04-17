<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AddressBook */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Address Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->address_book_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->address_book_id], [
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
            'address_book_id',
            'network_id',
            'network_name',
            'member_id',
            'type',
            'name',
            'telephone',
            'fixed_line',
            'address_library_id',
            'address',
            'gate',
            'is_default',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
