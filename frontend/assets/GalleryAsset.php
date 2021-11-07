<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class GalleryAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'css/gallery.css',
    ];
    public $js = [
    ];
}