<?php


namespace booking\services\booking;


use booking\entities\booking\Discount;
use booking\forms\booking\DiscountForm;
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
        $promo = $this->generatePromo($form->entities);
        $discount = Discount::create(
            $form->entities,
            $form->entities_id,
            $promo,
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

    public static function generatePromo($entities): string
    {
        // TODO Заглушка Stay
        $code = ['0', '1', '2', '3', '4', '5','6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
            'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y', 'Z'];
        $result = '';
        switch ($entities) {
            case Discount::E_OFFICE_USER: $result = 'O'; break;
            case Discount::E_ADMIN_USER: $result = 'A'; break;
            case Discount::E_USER_LEGAL: $result = 'L'; break;
            case Discount::E_BOOKING_TOUR: $result = 'T'; break;
            case Discount::E_BOOKING_STAY: $result = 'S'; break;
            case Discount::E_BOOKING_CAR: $result = 'C'; break;
            case Discount::E_BOOKING_FUN: $result = 'F'; break;
        }
        $time = time();
        $div = ($time - 1.5 *(10 ** 9)) * rand(1, 999) + \Yii::$app->user->id * (10 ** 11);// + microtime();
        while (true) {
            $mod = $div % 36;
            $result .= $code[$mod];
            $div = intdiv($div, 36);
            if ($div < 36) {
                //$result .= $code[$div];
                break;
            }
        }
        return $result;
    }


}