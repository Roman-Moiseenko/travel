<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MapPageItemAsset extends AssetBundle
{
    public $css = [
        'css/map_panel.css',
    ];
    public $js = [
      //  'js/map_panel.js',
        'js/map_page_item.js',
    ];
}
