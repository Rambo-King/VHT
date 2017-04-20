<?php
$this->title = 'Account Center';
?>
<div class="content">
    <h1>ACCOUNT CENTER</h1>

    <div class="account-center">
        <?/*= $this->render('//member/menu') */?>
        <?= $this->render('menu') ?>

        <div class="main">
            Hello, <?= $email ?>! <br/>
            From your My Account Dashboard
        </div>
    </div>
</div>

<?php
$this->registerCssFile('css/account.css', ['depends' => 'app\assets\AppAsset']);
?>