<?php


namespace booking\repositories\booking;


use booking\entities\admin\user\UserLegal;
use booking\entities\booking\ReviewInterface;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\booking\tours\Tour;

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
        return $this->sort_merge($tours, $stays, $cars);
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
        return $this->sort_merge($tours, $stays, $cars);
    }

    /** @return ReviewInterface[] */
    public function getByAdmin($admin_id, $last_day = 7): array
    {
        $old = time() - 3600 * 24 * $last_day;
        $tours = ReviewTour::find()->andWhere([
            'IN' ,
            'tour_id',
            Tour::find()->select('id')->andWhere([
                'IN',
                'legal_id',
                UserLegal::find()->select('id')->andWhere(['user_id' => $admin_id])])
            ])->orderBy(['created_at' => SORT_DESC])->all();
        $stays = []; $cars = [];
        /* ЗАГЛУШКА
        $stays = ReviewStay::find()->andWhere(['user_id' => $user_id])->all();

        $cars = ReviewCar::find()->andWhere(['user_id' => $user_id])->all();
        */
        return $this->sort_merge($tours, $stays, $cars);
    }

    private function sort_merge(array $tours, array $stays, array $cars): array
    {
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