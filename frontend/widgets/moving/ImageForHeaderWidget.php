<?php


namespace frontend\widgets\moving;


use yii\base\Widget;

class ImageForHeaderWidget extends Widget
{
    public $header;
    public $image;
    public $alt;
    public $path = null;

    public function run()
    {
        $image_file = \Yii::$app->params['staticHostInfo'] . ( $this->path ?? '/files/images/moving/') . $this->image;
        return $this->render('image_header_' . $this->header, [
            'alt' => $this->alt,
            'image_file' => $image_file,
            'path' => $this->path,
        ]);
    }
}