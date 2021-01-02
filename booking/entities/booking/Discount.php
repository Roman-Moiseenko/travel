<?php


namespace booking\entities\booking;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;
use booking\helpers\BookingHelper;
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
    const E_ADMIN_USER = \booking\entities\admin\User::class;
    const E_OFFICE_USER = \booking\entities\office\User::class;
    const E_USER_LEGAL = Legal::class;
    const E_BOOKING_TOUR = BookingTour::class;
    const E_BOOKING_STAY = BookingStay::class;
    const E_BOOKING_CAR = BookingCar::class;
    const E_BOOKING_FUN = BookingFun::class;

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
        if ($this->entities == Discount::E_OFFICE_USER) {
            $amount =  0;

            $tour = BookingTour::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->all();
            foreach ($tour as $item) {
                $amount += $item->bonus;
            }
            // TODO Заглушка Stay
/*
            $stay = BookingStay::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->all();
            foreach ($stay as $item) {
                $amount += $item->bonus;
            }*/

            $car = BookingCar::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->all();
            foreach ($car as $item) {
                $amount += $item->bonus;
            }
            $fun = BookingFun::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->all();
            foreach ($fun as $item) {
                $amount += $item->bonus;
            }
            return $this->count - $amount;
        }
        $tour = BookingTour::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->count();
        // TODO Заглушка Stay
        $stay = 0;
        $fun = BookingFun::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->count();
        $car = BookingCar::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->count();
        /*
        $stay = BookingStay::find()->andWhere(['discount_id' => $this->id])->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_NEW, BookingHelper::BOOKING_STATUS_PAY]])->count();
        */
        return $this->count - ($tour + $stay + $car + $fun);
    }

    public static function listEntities(): array
    {
        // TODO Заглушка Stay
        return [
            User::class,
            Legal::class,
            BookingTour::class,
            BookingStay::class,
            BookingCar::class,
            BookingFun::class,
        ];
    }

    public function getCaption()
    {
        // TODO Заглушка Stay
        switch ($this->entities) {
            case Discount::E_OFFICE_USER: return 'Провайдер'; break;
            case Discount::E_ADMIN_USER: return 'Все объекты'; break;
            case Discount::E_USER_LEGAL: return 'На организацию'; break;
            case Discount::E_BOOKING_TOUR: return 'На туры'; break;
            case Discount::E_BOOKING_STAY: return 'На жилище'; break;
            case Discount::E_BOOKING_CAR: return 'На авто'; break;
            case Discount::E_BOOKING_FUN: return 'На развлечения'; break;
        }
    }

    public function isOffice()
    {
        return $this->entities == Discount::E_OFFICE_USER;
    }


}