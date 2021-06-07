<?php

namespace office\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LandAsset extends AssetBundle
{
    public $css = [
    ];
    public $js = [
        'js/map_land.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
