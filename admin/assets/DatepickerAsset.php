<?php


namespace admin\assets;


use yii\web\AssetBundle;

class DatepickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-datepicker/dist';
    public $js = ['js/bootstrap-datepicker.min.js'];
    public $css = ['css/bootstrap-datepicker.min.css'];
}