<?php
$this->title = 'Account Center';
?>
<div class="content">
    <h1>ACCOUNT CENTER</h1>

    <div class="account-center">
        <?/*= $this->render('//member/menu') */?>
        <?= $this->render('menu') ?>

        <div class="main">
            <div class="welcome-msg">
                <strong>Hello, <?= $member->email ?> ! </strong>
                <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</p>
            </div>
            <div class="box-account box-recent">
                <div class="box-head">
                    <h2>Recent Orders</h2>
                    <a href="/member/order">View All</a>
                </div>
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Ship From</th>
                        <th>Ship To</th>
                        <th>Status</th>
                        <th>&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($orders as $o): ?>
                    <tr>
                        <td><?= $o->order_number?></td>
                        <td><?= date('d/m/Y H:i:s', $o->created_at) ?></td>
                        <td><?= $o->mailing_address ?></td>
                        <td><?= $o->receiving_address ?></td>
                        <td><em><?= $o->state ?></em></td>
                        <td><a href="/order/view/<?= $o->order_id ?>">View Order</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-account box-info">
                <div class="box-head">
                    <h2>Account Information</h2>
                </div>
                <div class="col2-set">
                    <div class="box">
                        <div class="box-title">
                            <h3>Contact Information</h3>
                            <a href="/member/information">Edit</a>
                        </div>
                        <div class="box-content">
                            <p>
                                <?= $member->email ?><br>
                                <?= $member->account_number ?><br>
                                <a href="/member/password">Change Password</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col2-set">
                    <div class="box">
                        <div class="box-title">
                            <h3>Address Book</h3>
                            <a href="/member/book/">Manage Addresses</a>
                        </div>
                        <div class="box-content">
                            <div class="col-1">
                                <h4>Default Mailing Address</h4>
                                <?php if(!is_null($mailing)): ?>
                                    <address>
                                        <?= $mailing->name ?><br/>
                                        <?= $mailing->address ?>
                                        <?= $mailing->gate ?><br/>
                                        T:<?= $mailing->telephone.' '.$mailing->fixed_line ?><br/>
                                        <a href="/">Edit Address</a>
                                    </address>
                                <?php else: ?>
                                    You have no default mailing address entries in your address book.
                                <?php endif; ?>
                            </div>
                            <div class="col-2">
                                <h4>Default Receiving Address</h4>
                                <?php if(!is_null($receiving)): ?>
                                    <address>
                                        <?= $receiving->name ?><br/>
                                        <?= $receiving->address ?>
                                        <?= $receiving->gate ?><br/>
                                        T:<?= $receiving->telephone.' '.$receiving->fixed_line ?><br/>
                                        <a href="/">Edit Address</a>
                                    </address>
                                <?php else: ?>
                                    You have no default receiving address entries in your address book.
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCssFile('css/account.css', ['depends' => 'app\assets\AppAsset']);
?>