<?php


namespace admin\assets;


use yii\web\AssetBundle;

class CalendarTourAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/calendar.css',
    ];
    public $js = [
        'js/calendar_tour.js',
    ];

}