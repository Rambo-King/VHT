<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'My Orders';
?>
    <div class="content">
        <h1>ACCOUNT CENTER</h1>

        <div class="account-center">
            <?/*= $this->render('//member/menu') */?>
            <?= $this->render('menu') ?>

            <div class="main">
                <div class="page"><?= $plist; ?></div>
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
                            <td><a href="/member/order/view/<?= $o->order_id ?>">View Order</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="page"><?= $plist; ?></div>
                <div class="buttons-set">
                    <a onclick="javascript:history.back(-1)" class="btn btn-success">Back</a>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCssFile('css/account.css', ['depends' => 'app\assets\AppAsset']);
?>