<?php


namespace booking\repositories\booking;


use booking\entities\booking\ReviewInterface;
use booking\entities\booking\tours\ReviewTour;

class ReviewRepository
{
    /** @return ReviewInterface[] */
    public function getByLegal($legal_id): array
    {
        $tours = [];
        //TODO Сложный запрос по турам

        //ReviewTour::find()->andWhere(['user_id' => $legal_id])->all();
        $stays = []; $cars = [];
        /* ЗАГЛУШКА
        $stays = ReviewStay::find()->andWhere(['user_id' => $user_id])->all();

        $cars = ReviewCar::find()->andWhere(['user_id' => $user_id])->all();
        */
        $result = array_merge($tours, $stays, $cars);
        usort($result, function (ReviewInterface $a, ReviewInterface $b) {
            if ($a->getDate() > $b->getDate()) {
                return -1;
            } else {
                return 1;
            }
        });
        return $result;
    }

    /** @return ReviewInterface[] */
    public function getByUser($user_id): array
    {
        $tours = ReviewTour::find()->andWhere(['user_id' => $user_id])->all();
        $stays = []; $cars = [];
        /* ЗАГЛУШКА
        $stays = ReviewStay::find()->andWhere(['user_id' => $user_id])->all();

        $cars = ReviewCar::find()->andWhere(['user_id' => $user_id])->all();
        */
        $result = array_merge($tours, $stays, $cars);
        usort($result, function (ReviewInterface $a, ReviewInterface $b) {
            if ($a->getDate() > $b->getDate()) {
                return -1;
            } else {
                return 1;
            }
        });
        return $result;
    }
}