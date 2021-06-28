<?php


namespace frontend\widgets\templates;


use yii\base\Widget;

class ImageH2Widget extends Widget
{

    public $directory;
    public $image_file;
    public $alt;

    public function run()
    {
        $path = \Yii::$app->params['staticHostInfo'] . '/files/images/' . $this->directory . '/';
        $full_file_name = $path . $this->image_file ;
        return
            '<div class="item-responsive item-2-0by1">' .
            '   <div class="content-item">' .
            '       <img src="' . $full_file_name . '" alt="' . $this->alt . '" title="' . $this->alt . '" width="100%" loading="lazy">' .
            '  </div>' .
            '</div>';
    }
}