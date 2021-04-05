<?php


namespace booking\entities\shops;


use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Photo;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\helpers\BookingHelper;
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
    /** @var Meta $meta */
    public $meta;



 /*   public static function create($user_id, $legal_id, $name, $name_en, $description, $description_en): self
    {
        $shop = new static();
        $shop->created_at = time();
        $shop->user_id = $user_id;
        $shop->legal_id = $legal_id;
        $shop->name = $name;
        $shop->name_en = $name_en;
        $shop->description = $description;
        $shop->description_en = $description_en;
        $shop->status = StatusHelper::STATUS_INACTIVE;
        return $shop;
    }*/

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

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'reviews',
                ],
            ],

        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    //**** Контакты (ContactAssign) **********************************


    //****** Внешние связи *****


    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewShop::class, ['shop_id' => 'id']);
    }
}