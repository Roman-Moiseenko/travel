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
        //'//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700&display=swap',
        'css/site.css',
        //'css/stylesheet.css',
       // 'css/glyphicon.css',
//        'css/swiper.min.css',
//        'css/multi_timer.css',
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
