<?php


namespace booking\entities\user;


use booking\entities\booking\tours\Tour;
use booking\entities\booking\WishlistItemInterface;
use booking\entities\foods\Food;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $user_id
 * @property integer $food_id
 * @property Food $food
 */
class WishlistFood extends ActiveRecord implements WishlistItemInterface
{

    public static function create($food_id): self
    {
        $wishlist = new static();
        $wishlist->food_id = $food_id;
        return $wishlist;
    }


    public function isFor($food_id): bool
    {
        return $this->food_id == $food_id;
    }

    public function getFood(): ActiveQuery
    {
        return $this->hasOne(Food::class, ['id' => 'food_id']);
    }

    public static function tableName()
    {
        return '{{%user_wishlist_foods}}';
    }

    /** ===> WishlistItemInterface */

    public function getName(): string
    {
        return $this->food->name;
    }

    public function getLink(): string
    {
        return Url::to(['food/view', 'id' => $this->food_id]);
    }

    public function getPhoto(): string
    {
        return $this->food->mainPhoto->getThumbFileUrl('file', 'cabinet_list');
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_FOOD;
    }

    public function getId(): string
    {
        return $this->food_id;
    }

    public function getRemoveLink(): string
    {
        return Url::to(['cabinet/wishlist/del-food', 'id' => $this->food_id]);
    }
}