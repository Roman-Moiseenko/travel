<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class FunAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'css/multi_timer.css',
    ];
    public $js = [
        'js/calendar_fun.js',
    ];
}