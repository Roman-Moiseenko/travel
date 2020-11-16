<?php


namespace booking\entities\user;


use booking\entities\booking\cars\Car;
use booking\entities\booking\WishlistItemInterface;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $user_id
 * @property integer $car_id
 * @property Car $car
 */
class WishlistCar extends ActiveRecord implements WishlistItemInterface
{

    public static function create($car_id): self
    {
        $wishlist = new static();
        $wishlist->car_id = $car_id;
        return $wishlist;
    }

    public function isFor($car_id): bool
    {
        return $this->car_id == $car_id;
    }

    public function getCar(): ActiveQuery
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }

    public static function tableName()
    {
        return '{{%user_wishlist_cars}}';
    }

    /** ===> WishlistItemInterface */

    public function getName(): string
    {
        return $this->car->getName();
    }

    public function getLink(): string
    {
        return Url::to(['car/view', 'id' => $this->car_id]);
    }

    public function getPhoto(): string
    {
        return $this->car->mainPhoto->getThumbFileUrl('file', 'cabinet_list');
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_CAR;
    }

    public function getId(): string
    {
        return $this->car_id;
    }

    public function getRemoveLink(): string
    {
        return Url::to(['cabinet/wishlist/del-car', 'id' => $this->car_id]);
    }
}