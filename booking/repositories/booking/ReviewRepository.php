<?php


namespace booking\repositories\booking;


use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\ReviewCar;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\ReviewFun;
use booking\entities\booking\BaseReview;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\booking\tours\Tour;
use booking\helpers\scr;

class ReviewRepository
{
    /** @return BaseReview[] */
    public function getByLegal($legal_id): array
    {
        $tours = ReviewTour::find()
            ->andWhere([
                'IN',
                'tour_id',
                Tour::find()->select('id')->andWhere(['legal_id' => $legal_id])
            ])
            ->andWhere(['status' => ReviewTour::STATUS_ACTIVE])
            ->all();

        //TODO Заглушка Stay
        $stays = [];

        $cars = ReviewCar::find()
            ->andWhere([
                'IN',
                'car_id',
                Car::find()->select('id')->andWhere(['legal_id' => $legal_id])
            ])
            ->andWhere(['status' => ReviewCar::STATUS_ACTIVE])
            ->all();
        $funs = ReviewFun::find()
            ->andWhere([
                'IN',
                'fun_id',
                Fun::find()->select('id')->andWhere(['legal_id' => $legal_id])
            ])
            ->andWhere(['status' => ReviewFun::STATUS_ACTIVE])
            ->all();

        /* ЗАГЛУШКА
        $stays = ReviewStay::find()->andWhere(['IN', 'stay_id', Stay::find()->select('id')->andWhere(['legal_id' => $legal_id])->all()])->all();
        */
        return $this->sort_merge($tours, $stays, $cars, $funs);
    }

    /** @return BaseReview[] */
    public function getByUser($user_id): array
    {
        $tours = ReviewTour::find()->andWhere(['user_id' => $user_id])->andWhere(['status' => ReviewTour::STATUS_ACTIVE])->all();
        //TODO Заглушка Stay
        $stays = [];
        $cars = ReviewCar::find()->andWhere(['user_id' => $user_id])->andWhere(['status' => ReviewCar::STATUS_ACTIVE])->all();;
        $funs = ReviewFun::find()->andWhere(['user_id' => $user_id])->andWhere(['status' => ReviewFun::STATUS_ACTIVE])->all();;
        /* ЗАГЛУШКА
        $stays = ReviewStay::find()->andWhere(['user_id' => $user_id])->all();

        $cars = ReviewCar::find()->andWhere(['user_id' => $user_id])->all();
        */
        return $this->sort_merge($tours, $stays, $cars, $funs);
    }

    /** @return BaseReview[] */
    public function getByAdmin($admin_id, $last_day = 7): array
    {
        $old = time() - 3600 * 24 * $last_day;
        $tours = ReviewTour::find()->andWhere([
            'IN',
            'tour_id',
            Tour::find()->select('id')->andWhere(['user_id' => $admin_id])
        ])
            ->andWhere(['status' => ReviewTour::STATUS_ACTIVE])
            ->andWhere(['>=', 'created_at', $old])
            ->orderBy(['created_at' => SORT_DESC])->all();
        $stays = [];

        $cars = ReviewCar::find()->andWhere([
            'IN',
            'car_id',
            Car::find()->select('id')->andWhere(['user_id' => $admin_id])
        ])
            ->andWhere(['status' => ReviewCar::STATUS_ACTIVE])
            ->andWhere(['>=', 'created_at', $old])
            ->orderBy(['created_at' => SORT_DESC])->all();
        $funs = ReviewFun::find()->andWhere([
            'IN',
            'fun_id',
            Fun::find()->select('id')->andWhere(['user_id' => $admin_id])
        ])
            ->andWhere(['status' => ReviewFun::STATUS_ACTIVE])
            ->andWhere(['>=', 'created_at', $old])
            ->orderBy(['created_at' => SORT_DESC])->all();

        //TODO Заглушка Stays

        /*$stays = ReviewStay::find()->andWhere(['user_id' => $user_id])->all();


        */
        return $this->sort_merge($tours, $stays, $cars, $funs);
    }

    private function sort_merge(array $tours, array $stays, array $cars, array $funs): array
    {
        $result = array_merge($tours, $stays, $cars, $funs);
        usort($result, function (BaseReview $a, BaseReview $b) {
            if ($a->getDate() > $b->getDate()) {
                return -1;
            } else {
                return 1;
            }
        });
        return $result;
    }
}