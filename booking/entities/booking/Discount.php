<?php


namespace booking\entities\booking;


use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;
use yii\db\ActiveRecord;

/**
 * Class Discount
 * @package booking\entities\booking
 * @property int $id
 * @property int $created_at
 * @property int $who
 * @property string $entities
 * @property int $entities_id
 * @property string $promo
 * @property int $percent
 * @property int $count
 */
class Discount extends ActiveRecord
{
    const WHO_ADMIN = 1;
    const WHO_PROVIDER = 2;

    public static function create($who, $entities, $entities_id, $promo, $percent, $count = 1): self
    {
        $discount = new static();
        $discount->who = $who;
        $discount->created_at = time();
        $discount->entities = $entities;
        $discount->entities_id = $entities_id;
        $discount->promo = $promo;
        $discount->percent = $percent;
        $discount->count = $count;
        return $discount;
    }

    public static function tableName()
    {
        return '{{%booking_discount}}';
    }

    public function draft()
    {
        $this->count = -1;
    }

    public function isActive(): bool
    {
        return $this->count > 0;
    }

    public function getBookings()
    {
        //TODO !!!!!!!!!!!!!!!!!
    }


    public static function listEntities(): array
    {
        return [
            User::class,
            UserLegal::class,
            BookingTour::class,
            BookingStay::class,
            BookingCar::class
        ];
    }

}