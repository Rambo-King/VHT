<?php
$this->title = 'Address Book';
?>
    <div class="content">
        <h1>ACCOUNT CENTER</h1>

        <div class="account-center">
            <?= $this->render('menu') ?>

            <div class="main">
                <div class="page-title title-buttons"></div>
                <?php
                if(Yii::$app->session->hasFlash('success')){
                    echo '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
                }
                ?>
                <h2 class="table-caption">DEFAULT ADDRESSES</h2>
                <div class="col2-set order-info-box">
                    <div class="col-1">
                        <div class="box-top">
                            <h2>Default Mailing Address</h2>
                        </div>
                        <div class="box-content">
                            <?php if(!is_null($mailing)): ?>
                                <address>
                                    <?= $mailing->name ?><br/>
                                    <?= $mailing->address ?>
                                    <?= $mailing->gate ?><br/>
                                    T: <?= $mailing->telephone.' '.$mailing->fixed_line ?><br/>
                                    <a href="/book/modify/<?= $mailing->address_book_id ?>">Edit Address</a>
                                </address>
                            <?php else: ?>
                                You have no default mailing address entries in your address book.
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="box">
                            <div class="box-top">
                                <h2>Default Receiving Address</h2>
                            </div>
                            <div class="box-content">
                                <?php if(!is_null($receiving)): ?>
                                    <address>
                                        <?= $receiving->name ?><br/>
                                        <?= $receiving->address ?>
                                        <?= $receiving->gate ?><br/>
                                        T: <?= $receiving->telephone.' '.$receiving->fixed_line ?><br/>
                                        <a href="/book/modify/<?= $receiving->address_book_id ?>">Edit Address</a>
                                    </address>
                                <?php else: ?>
                                    You have no default receiving address entries in your address book.
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="table-caption">ADDITIONAL ADDRESS ENTRIES</h2>
                <div class="col2-set order-info-box">
                    <?php if($books): ?>
                        <?php foreach($books as $i=>$book): ?>
                            <div class="<?= $i%2==0 ? 'col-1' : 'col-2' ?>">
                                <div class="box-content">
                                    <address>
                                        <?= $book->name ?><br/>
                                        <?= $book->address ?>
                                        <?= $book->gate ?><br/>
                                        T: <?= $book->telephone.' '.$book->fixed_line ?><br/>
                                        Type: <?= $book->type == 1 ? 'Mailing' : 'Receiving' ?> Address<br/>
                                        <a href="/book/modify/<?= $book->address_book_id ?>">Edit Address</a>
                                    </address>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>You have no additional address entries in your address book.</p>
                    <?php endif; ?>
                </div>
                <div class="buttons-set">
                    <a onclick="javascript:history.back(-1)" class="btn btn-success">Back</a>
                    <a href="/book/create" class="btn btn-primary">ADD NEW ADDRESS BOOK</a>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCssFile('css/account.css', ['depends' => 'app\assets\AppAsset']);
?>