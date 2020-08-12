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
        '//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700',
        'css/site.css',
        'css/opencart.css',
        'css/stylesheet.css',
        'css/font-awesome/css/font-awesome.css'

    ];
    public $js = [
        'js/common.js',
        'js/site.js',
    ];
    public $depends = [
        //  'frontend\assets\MagnificPopupAsset',
        // 'sersid\fontawesome\Asset',
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}
