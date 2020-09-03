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
 * @property int $user_id
 * @property int $created_at
 * @property string $entities
 * @property int $entities_id
 * @property string $promo
 * @property int $percent
 * @property int $count
 */
class Discount extends ActiveRecord
{
    const E_ADMIN_USER = \booking\entities\admin\user\User::class;
    const E_OFFICE_USER = \booking\entities\office\user\User::class;
    const E_USER_LEGAL = UserLegal::class;
    const E_BOOKING_TOUR = BookingTour::class;
    const E_BOOKING_STAY = BookingStay::class;
    const E_BOOKING_CAR = BookingCar::class;

    public static function create($entities, $entities_id, $promo, $percent, $count = 1): self
    {
        $discount = new static();
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

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function countNotUsed(): int
    {
        $tour = BookingTour::find()->andWhere(['discount_id' => $this->id])->count();
        // TODO Заглушка Stay Car
        $stay = 0; $car = 0;
        /*
        $stay = BookingStay::find()->andWhere(['discount_id' => $this->id])->count();
        $car = BookingCar::find()->andWhere(['discount_id' => $this->id])->count();*/
        return $this->count - ($tour + $stay + $car);
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

    public function getCaption()
    {
        switch ($this->entities) {
            case Discount::E_OFFICE_USER: return 'Провайдер'; break;
            case Discount::E_ADMIN_USER: return 'Все объекты'; break;
            case Discount::E_USER_LEGAL: return 'На организацию'; break;
            case Discount::E_BOOKING_TOUR: return 'На туры'; break;
            case Discount::E_BOOKING_STAY: return 'На жилище'; break;
            case Discount::E_BOOKING_CAR: return 'На авто'; break;
        }
    }

}