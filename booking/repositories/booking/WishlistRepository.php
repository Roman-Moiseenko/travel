<?php


namespace booking\repositories\booking;


use booking\entities\user\WishlistCar;
use booking\entities\user\WishlistFood;
use booking\entities\user\WishlistFun;
use booking\entities\user\WishlistProduct;
use booking\entities\user\WishlistStay;
use booking\entities\user\WishlistTour;
use booking\entities\booking\WishlistItemInterface;

class WishlistRepository
{

    /** @return WishlistItemInterface[] */
    public function getAll($user_id): array
    {
        $tours = WishlistTour::find()->andWhere(['user_id' => $user_id])->all();
        $cars = WishlistCar::find()->andWhere(['user_id' => $user_id])->all();
        $funs = WishlistFun::find()->andWhere(['user_id' => $user_id])->all();
        $stays = WishlistStay::find()->andWhere(['user_id' => $user_id])->all();
        $foods = WishlistFood::find()->andWhere(['user_id' => $user_id])->all();
        $products = WishlistProduct::find()->andWhere(['user_id' => $user_id])->all();

        //TODO ** BOOKING_OBJECT **
        return array_merge($tours, $stays, $cars, $funs, $foods, $products);
    }

}