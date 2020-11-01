<?php


namespace admin\widgest\chart;


use yii\web\AssetBundle;

class ChartJSAsset extends AssetBundle
{
    public $sourcePath = '@bower/chart.js';

    /**
     * @inherit
     */
    public $css = [
        'dist/Chart.css'
    ];

    /**
     * @inherit
     */
    public $js = [
        'dist/Chart.js'
    ];

    public function init()
    {
        parent::init();
    }
}