<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700&display=swap',
        'css/site.css',
        'css/top.css',
        'css/stylesheet.css',
        //'css/glyphicon.css',
        'css/shop.css',
        'css/design2.css',
//        'css/swiper.min.css',
//        'css/multi_timer.css',
        //'font-awesome/css/font-awesome.css'
    ];
    public $js = [
        //'js/swiper.js',
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        //'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}
