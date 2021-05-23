<?php


namespace frontend\widgets\moving;


use yii\base\Widget;

class ImageForHeaderWidget extends Widget
{
    public $header;
    public $image;
    public $alt;

    public function run()
    {
        return $this->render('image_header_' . $this->header, [
            'alt' => $this->alt,
            'image_file' => $this->image,
        ]);
    }
}