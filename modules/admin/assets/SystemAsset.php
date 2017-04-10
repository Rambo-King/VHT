<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-11-11
 * Time: 下午3:07
 */

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class SystemAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'system/css/bootstrap.min.css',
        'system/css/font-awesome.min.css',
        'system/css/ionicons.min.css',
        'system/css/admin.css',
    ];
    /*public $jsOptions = [
        'condition' => 'It IE 9',
    ];*/
    public $js = [
        'system/js/bootstrap.min.js',
        'system/js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

} 