<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>

<div class="order-quick">
    <h1>Order Quick</h1>

    <h3>Mailing Info</h3>
    <?php echo Html::a('Add Mailing Address', '#', [
        'id' => 'create',
        'data-toggle' => 'modal',
        'data-target' => '#create-modal',
        'class' => 'btn btn-success',
        ]);
    ?>

    <h3>Receiving Info</h3>
    <?php echo Html::a('Add Receiving Address', '#', [
        'id' => 'create',
        'data-toggle' => 'modal',
        'data-target' => '#create-modal',
        'class' => 'btn btn-success',
    ]);
    ?>

    <h3>Product List</h3>

    <?php
    Modal::begin([
        'id' => 'create-modal',
        'header' => '<h4 class="modal-title">Add Mailing Address</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    ]);
    echo 'Say hello... waybill';
    Modal::end();
    ?>
</div>

