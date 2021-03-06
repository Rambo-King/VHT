<?php
use yii\helpers\Html;
use app\modules\admin\assets\SystemAsset;
use yii\widgets\Breadcrumbs;
SystemAsset::register($this);

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <title>VHT Data Management</title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
    <?php $this->beginBody() ?>
    <header class="header">
        <a href="/admin" class="logo">VHT Data Management</a>
        <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <a class="logo navbar-right" target="_blank" href="/">System Reception</a>
        <div class="navbar-right">
        <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
                <span><?= Yii::$app->admin->identity->account_name ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
                <li class="user-header bg-light-blue">
                    <img src="/system/image/avatar3.png" class="img-circle" alt="User Image" />
                    <p>
                        <?= Yii::$app->admin->identity->account_name ?> - Web Developer
                        <small>Member since Apr. 2017</small>
                    </p>
                </li>
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="/admin/manager/view/<?= Yii::$app->admin->getId() ?>" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <?= Html::beginForm(['/admin/manager/logout'], 'post', ['class' => ''])
                        . Html::submitButton(
                        'Logout (' . Yii::$app->admin->identity->username . ')',
                        ['class' => 'btn btn-default btn-flat',]
                        )
                        . Html::endForm()
                        ?>
                    </div>
                </li>
            </ul>
        </li>
        </ul>
        </div>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="/system/image/avatar3.png" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>Hello, <?= Yii::$app->admin->identity->account_name ?></p>

                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="active">
                        <a href="/admin">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            <small class="badge pull-right bg-yellow">Dashboard</small>
                        </a>
                    </li>

                    <li class="treeview <?= in_array($controller, ['manager']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-group"></i> <span>Manager</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?= $controller=='manager' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/manager'])?>"><i class="fa fa-angle-double-right"></i> Manager</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= \yii\helpers\Url::to(['/admin/address-library']) ?>">
                            <i class="fa fa-cloud"></i> <span>Address Library</span><small class="badge pull-right bg-green">source</small>
                        </a>
                    </li>

                    <li class="treeview <?= in_array($controller, ['network', 'network-area']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-sitemap"></i> <span>Network</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?= $controller=='network' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/network'])?>"><i class="fa fa-angle-double-right"></i> Network</a></li>
                            <li <?= $controller=='network-area' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/network-area'])?>"><i class="fa fa-angle-double-right"></i> Jurisdiction Area</a></li>
                        </ul>
                    </li>

                    <li class="treeview <?= in_array($controller, ['member', 'address-book']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-user"></i> <span>Member</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?= $controller=='member' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/member'])?>"><i class="fa fa-angle-double-right"></i> Member</a></li>
                            <li <?= $controller=='address-book' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/address-book'])?>"><i class="fa fa-angle-double-right"></i> Address Book</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= \yii\helpers\Url::to(['/admin/unit']) ?>">
                            <i class="fa fa-calendar"></i> <span>Unit</span>
                            <small class="badge pull-right bg-red">calc</small>
                        </a>
                    </li>

                    <li class="treeview <?= in_array($controller, ['order', 'order-product', 'waybill']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-list"></i> <span>Order</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?= $controller=='order' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/order'])?>"><i class="fa fa-angle-double-right"></i> Order</a></li>
                            <li <?= $controller=='order-product' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/order-product'])?>"><i class="fa fa-angle-double-right"></i> Order Product</a></li>
                            <li <?= $controller=='waybill' ? 'class="active"' : '' ?>><a href="<?= \yii\helpers\Url::to(['/admin/waybill'])?>"><i class="fa fa-angle-double-right"></i> Waybill</a></li>
                        </ul>
                    </li>

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <section class="content-header">
                <?= Breadcrumbs::widget([
                    'homeLink'=>['label' => ' Dashboard','url' => '/admin', 'target'=>'_top', 'class' => 'fa fa-dashboard'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?= $content ?>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>