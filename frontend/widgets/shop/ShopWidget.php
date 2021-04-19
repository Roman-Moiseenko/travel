<?php


namespace frontend\widgets\shop;


use booking\entities\shops\Shop;
use yii\base\Widget;

class ShopWidget extends Widget
{
    /** @var $shop Shop */
    public $shop;

    public function run()
    {
        return $this->render('shop', [
            'products' => $this->shop->activeProducts,
        ]);
    }

}