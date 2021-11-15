<?php


namespace frontend\widgets\gallery;


use booking\entities\booking\BasePhoto;
use booking\entities\touristic\fun\Category;
use yii\base\Widget;
use yii\helpers\Url;

class GalleryStayWidget extends Widget
{
    /** @var $category Category */
    public $categories;

    public $mobile;

    public function run()
    {
        $profiles = [
            0 => 'c3',
            1 => 'c1r2',
            2 => 'c2',
            3 => 'c2',
            4 => 'c2',
            5 => 'c1',
            6 => 'c3',
            //7 => 'c2',
        ];

        return $this->render('gallery_stay', [
            'profiles' => $profiles,
            'mobile' => $this->mobile,
            'categories' => $this->categories,
        ]);
    }
}