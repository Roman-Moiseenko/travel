<?php


namespace booking\services\booking;


use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\Discount;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
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

    public function create(DiscountForm $form): Discount
    {
        $discount = Discount::create(
            $form->entities,
            $form->entities_id,
            $form->promo,
            $form->percent,
            $form->count
            );

        $this->discounts->save($discount);
        return $discount;
    }

    public function draft($id): void
    {
        $discount = $this->discounts->get($id);
        $discount->draft();
        $this->discounts->save($discount);
    }

    public function remove($id): void
    {
        $discount = $this->discounts->get($id);
        $this->discounts->remove($discount);
    }
}