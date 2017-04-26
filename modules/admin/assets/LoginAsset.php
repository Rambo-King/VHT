<?php
namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'system/css/bootstrap.min.css',
        'system/css/login.css',
    ];
    /*public $jsOptions = [
        'condition' => 'It IE 9',
    ];*/
    public $js = [
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}