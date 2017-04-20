<?php
//$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>

<div class="navigation">
    <div class="nav-title">
        MY ACCOUNT
    </div>
    <div class="nav-contain">
        <div class="nav">
            <?php if($action == 'account'): ?>
                <strong>Account Dashboard</strong>
            <?php else: ?>
                <a href="/member/account"><span>Account Dashboard</span></a>
            <?php endif; ?>
        </div>
        <div class="nav">
            <?php if($action == 'info'): ?>
                <strong>Account Information</strong>
            <?php else: ?>
                <a href="/member/information"><span>Account Information</span></a>
            <?php endif; ?>
        </div>
        <div class="nav">
            <?php if($action == 'book'): ?>
                <strong>Address Book</strong>
            <?php else: ?>
                <a href="/member/book"><span>Address Book</span></a>
            <?php endif; ?>
        </div>
        <div class="nav">
            <?php if($action == 'order'): ?>
                <strong>My Orders</strong>
            <?php else: ?>
                <a href="/member/order"><span>My Orders</span></a>
            <?php endif; ?>
        </div>
    </div>
</div>