<?php
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$do = $controller.'/'.$action;
?>

<div class="navigation">
    <div class="nav-title">
        MY ACCOUNT
    </div>
    <div class="nav-contain">
        <div class="nav">
            <?php if(in_array($do, ['member/account'])): ?>
                <strong>Account Dashboard</strong>
            <?php else: ?>
                <a href="/member/account"><span>Account Dashboard</span></a>
            <?php endif; ?>
        </div>
        <div class="nav">
            <?php if(in_array($do, ['order/quick'])): ?>
                <strong>Order Quick</strong>
            <?php else: ?>
                <a href="/order/quick"><span>Order Quick</span></a>
            <?php endif; ?>
        </div>
        <div class="nav">
            <?php if(in_array($do, ['member/information', 'member/password'])): ?>
                <strong>Account Information</strong>
            <?php else: ?>
                <a href="/member/information"><span>Account Information</span></a>
            <?php endif; ?>
        </div>
        <div class="nav">
            <?php if(in_array($do, ['member/book', 'book/create', 'book/modify'])): ?>
                <strong>Address Book</strong>
            <?php else: ?>
                <a href="/member/book"><span>Address Book</span></a>
            <?php endif; ?>
        </div>
        <div class="nav">
            <?php if(in_array($do, ['member/order', 'order/view'])): ?>
                <strong>My Orders</strong>
            <?php else: ?>
                <a href="/member/order"><span>My Orders</span></a>
            <?php endif; ?>
        </div>
    </div>
</div>