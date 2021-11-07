<?php


namespace frontend\widgets;


use booking\entities\booking\BasePhoto;
use booking\entities\touristic\fun\Category;
use yii\base\Widget;
use yii\helpers\Url;

class GalleryFunWidget extends Widget
{
    /** @var $category Category */
    public $categories;

    public $mobile;

    public function run()
    {
        $profiles = [
            0 => 'c3',
            1 => 'c1',
            2 => 'c2',
            3 => 'c2',
            4 => 'c1r2',
            5 => 'c2',
            6 => 'c1',
            7 => 'c2',
        ];

        return $this->render('gallery_fun', [
            'profiles' => $profiles,
            'mobile' => $this->mobile,
            'categories' => $this->categories,
        ]);
    }
}