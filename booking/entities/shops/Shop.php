<?php


namespace booking\entities\shops;


use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Photo;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Product;
use booking\helpers\BookingHelper;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Shop
 * @package booking\entities\shops
 ********************************* Внешние связи
 * @property ReviewShop[] $reviews
 * @property Product[] $products
 *
 *********************************** Скрытые поля
 */

class Shop extends BaseShop
{



    //**************** Set ****************************



    //**************** Get ****************************



    //**************** is ****************************

    public function isAd(): bool
    {
        return false;
    }

    public static function tableName()
    {
        return '{{%shops}}';
    }


    //****** Внешние связи ****************************


    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewShop::class, ['shop_id' => 'id']);
    }

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['shop_id' => 'id']);
    }
}