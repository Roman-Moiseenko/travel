<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetMobile extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
       // 'js/site.js',
    ];
    public $depends = [
     //   'yii\web\YiiAsset',
       // 'yii\bootstrap4\BootstrapAsset',
       // 'yii\bootstrap4\BootstrapPluginAsset',
        //'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}
