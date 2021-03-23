<?php


namespace booking\services;


use booking\entities\PhotoResize;
use Imagine\Image\Box;
use Imagine\Gd\Imagine;

class PhotoResizeService
{
    public function resize($item, $quality, $max_width, $max_height)
    {
        $ext = pathinfo($item, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'jpeg') return;
        $photoResize = PhotoResize::find()->andWhere(['file' => $item])->one();
        if ($photoResize) return; //Файл уже был изменен

        echo $item;
        $imagine = new Imagine();
        $image = $imagine->open($item);
        if ($max_width && $max_height) {
            //Будем менять размер.
            $size = $image->getSize();
            $w_origin = $size->getWidth();
            $h_origin = $size->getHeight();
            echo ' size: ' . $w_origin . 'x' . $h_origin . ' => ';
            if ($h_origin > $w_origin) {
                $h_new = $max_height; //Ограничиваем высоту
                $w_new = (int)($max_height / $h_origin * $w_origin);
            } else { //Ограничиваем ширину
                $h_new = (int)($max_width / $w_origin * $h_origin);
                $w_new = $max_width;
            }
            echo $w_new . 'x' . $h_new;
            $image = $image->resize(new Box($w_new, $h_new));
        }
        $image->save($item, ['jpeg_quality' => $quality]);
        $photoResize = PhotoResize::create($item);
        $photoResize->save();
        echo ' resize'  . PHP_EOL;

    }
}