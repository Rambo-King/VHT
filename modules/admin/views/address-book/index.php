<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AddressBookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Address Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-book-index">

    <?php
    if(Yii::$app->session->hasFlash('success')){
        echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Address Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],

            'address_book_id',
            'network_name',
            [
                'attribute' => 'member_email',
                'value' => 'member.email',
                'label' => 'Member',
            ],
            [
                'attribute' => 'type',
                'filter' => \app\models\AddressBook::TypeList(),
                'value' => function($m){
                        return \app\models\AddressBook::Type($m->type);
                    }
            ],
            'name',
            'telephone',
            'fixed_line',
            'address',
            'gate',
            'is_default',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'headerOptions' => ['width' => '142'],
                'template' => '{update} {delete} {area}',
                'buttons' => [
                    'update' => function($url, $model, $key){
                            return Html::a("Modify", \yii\helpers\Url::to($url), ["class" => "btn btn-primary"]);
                        },
                    'delete' => function($url, $model, $key){
                            return '<a data-id="'.$key.'" onclick="DeleteConfirm(this);" href="javascript:;" class="btn btn-danger">Delete</a>';
                        }
                ],
            ],
        ],
    ]); ?>
</div>
