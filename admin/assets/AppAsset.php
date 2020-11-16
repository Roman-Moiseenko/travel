<?php

namespace admin\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/glyphicon.css',
        'css/calendar.css',
    ];
    public $js = [
        'js/map.js',
        'js/tours.js',
        'js/calendar_tour.js',
        'js/calendar_car.js',
        'js/booking_car.js',
        'js/booking_tour.js',
        'js/notice.js',
        'js/discount.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
