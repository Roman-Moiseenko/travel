<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MapBlogAsset extends AssetBundle
{
    public $js = [
        'js/widget_map_blog.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
