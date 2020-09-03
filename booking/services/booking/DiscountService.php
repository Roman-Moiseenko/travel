<?php


namespace booking\services\booking;


use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\Discount;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\booking\DiscountRepository;

class DiscountService
{

    /**
     * @var DiscountRepository
     */
    private $discounts;

    public function __construct(DiscountRepository $discounts)
    {

        $this->discounts = $discounts;
    }

    public function get($promo_code, BookingItemInterface $booking): int
    {
        /** @var Discount $discount */
        $discount = Discount::find()->andWhere(['promo' => $promo_code])->andWhere(['>', 'count', 0])->one();
        if (!$discount) return null;
        //Проверка на количество

        //Проверка на сущности
        if ($discount->entities == User::class) {
            $admin = $booking->getAdmin();
            if ($admin->id == $discount->entities_id) return $discount->id;
        }
        if ($discount->entities == UserLegal::class) {
            $legal = $booking->getLegal();
            if ($legal->id == $discount->entities_id) return $discount->id;
        }
        if (get_class($booking) == $discount->entities) {
            if ($discount->entities_id == null) return $discount->id;
            if ($booking->getParentId() == $discount->entities_id) return $discount->id;
        }
        return null;
    }

    private function countUse($id)
    {
        $discount = $this->discounts->get($id);
        $discount->count;


    }
}