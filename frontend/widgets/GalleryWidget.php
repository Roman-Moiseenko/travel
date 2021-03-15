<?php


namespace frontend\widgets;


use booking\entities\booking\BasePhoto;
use yii\base\Widget;

class GalleryWidget extends Widget
{
    /** @var $photo BasePhoto */
    public $photo;
    public $name;
    public $description;
    public $iterator;
    public $count;

    public function run()
    {
        return $this->render('gallery', [
            'photo' => $this->photo,
            'name' => $this->name,
            'description' => $this->description,
            'i' => $this->iterator,
            'count' => $this->count,
        ]);
    }
}