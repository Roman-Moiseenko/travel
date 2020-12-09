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
        'css/site_admin.css',
        'css/glyphicon.css',
        'css/calendar_admin.css',
    ];
    public $js = [
        'js/map_admin.js',
        'js/tours_admin.js',
        'js/calendar_tour_admin.js',
        'js/calendar_car_admin.js',
        'js/calendar_fun_admin.js',
        'js/booking_car_admin.js',
        'js/booking_tour_admin.js',
        'js/notice_admin.js',
        'js/discount_admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
