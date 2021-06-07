<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LandAsset extends AssetBundle
{

    public $js = [

        'js/map_land_frontend.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',

    ];
}
