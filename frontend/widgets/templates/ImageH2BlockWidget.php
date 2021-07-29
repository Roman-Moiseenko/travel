<?php


namespace frontend\widgets\templates;


use yii\base\Widget;

class ImageH2BlockWidget extends Widget
{

    public $directory;
    public $images;
    public $alt;
    public $scale;
    public $col;

    public function run()
    {
        $path = \Yii::$app->params['staticHostInfo'] . '/files/images/' . $this->directory . '/';
        $result = '<div class="row">';
        foreach ($this->images as $image) {
            $full_file_name = $path . $image;
            $result .=
                '   <div class="col-sm-' . $this->col .'">' .
                '      <div class="item-responsive ' . $this->scale .'">' .
                '           <div class="content-item">' .
                '              <img src="' . $full_file_name . '" alt="' . $this->alt . '" title="' . $this->alt . '" width="100%" loading="lazy">' .
                '           </div>' .
                '      </div>' .
                '   </div>'
            ;
        }
        $result .= '</div>';
        return $result;
    }
}