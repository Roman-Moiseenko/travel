<?php


namespace booking\repositories\booking;


use booking\entities\user\WishlistCar;
use booking\entities\user\WishlistTour;
use booking\entities\booking\WishlistItemInterface;

class WishlistRepository
{

    /** @return WishlistItemInterface[] */
    public function getAll($user_id): array
    {
        $tours = WishlistTour::find()->andWhere(['user_id' => $user_id])->all();
        $stays = []; $cars = [];
         //TODO ЗАГЛУШКА Stays
        /*$stays = WishlistStay::find()->andWhere(['user_id' => $user_id])->all();
        */
        $cars = WishlistCar::find()->andWhere(['user_id' => $user_id])->all();

        return array_merge($tours, $stays, $cars);
    }

}