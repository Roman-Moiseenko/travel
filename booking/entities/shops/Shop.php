<?php


namespace booking\entities\shops;


use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Photo;
use booking\entities\Lang;
use booking\entities\Meta;
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
 *
 *********************************** Скрытые поля


 */

class Shop extends BaseShop
{




   /* public function edit($name, $name_en, $description, $description_en): void
    {

    }*/


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


    //**** Контакты (ContactAssign) **********************************


    //****** Внешние связи *****


    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewShop::class, ['shop_id' => 'id']);
    }
}