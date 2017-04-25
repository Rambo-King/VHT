<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Order View';
?>
    <div class="content">
        <h1>ACCOUNT CENTER</h1>

        <div class="account-center">
            <?= $this->render('//member/menu') ?>

            <div class="main">
                <div class="page-title title-buttons">
                    <!--<a href="">Print Order</a>-->
                </div>
                <p>Order Date: <?= date('F d, Y', $order->created_at) ?></p>
                <div class="col2-set order-info-box">
                    <div class="col-1">
                        <div class="box-top">
                            <h2>Mailing Address (Ship From)</h2>
                        </div>
                        <div class="box-content">
                            <address>
                                <?= $order->mailing_name ?><br/>
                                <?= $order->mailing_address ?><br/>
                                T: <?= $order->mailing_telephone ?><br/>
                            </address>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="box">
                            <div class="box-top">
                                <h2>Receiving Address (Ship To)</h2>
                            </div>
                            <div class="box-content">
                                <address>
                                    <?= $order->receiving_name ?><br/>
                                    <?= $order->receiving_address ?><br/>
                                    T: <?= $order->receiving_telephone ?><br/>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-items">
                    <h2 class="table-caption">Items Ordered</h2>
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Length</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Qty</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($products as $p): ?>
                            <tr>
                                <td><?= $p->name?></td>
                                <td><?= $p->length ?>(<?= $p->length_unit_name ?>)</td>
                                <td><?= $p->width ?>(<?= $p->length_unit_name ?>)</td>
                                <td><?= $p->height ?>(<?= $p->length_unit_name ?>)</td>
                                <td><?= $p->weight ?>(<?= $p->weight_unit_name ?>)</td>
                                <td><?= $p->quantity ?></td>
                                <td><?= $p->description ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="buttons-set">
                    <a href="/member/order" class="btn btn-success">Back to My Orders</a>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCssFile('css/account.css', ['depends' => 'app\assets\AppAsset']);
?>