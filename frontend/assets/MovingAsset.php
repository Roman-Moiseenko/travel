<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MovingAsset extends AssetBundle
{
    public $js = [
        'js/close_link.js',
        'js/modal_widget.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
