<?php


namespace booking\repositories\booking;


use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\ReviewCar;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\ReviewFun;
use booking\entities\booking\BaseReview;
use booking\entities\booking\stays\ReviewStay;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\booking\tours\Tour;
use booking\helpers\scr;

class ReviewRepository
{
    /** @return BaseReview[] */
    public function getByLegal($legal_id): array
    {
        //TODO ** BOOKING_OBJECT **
        $tours = ReviewTour::find()
            ->andWhere([
                'IN',
                'tour_id',
                Tour::find()->select('id')->andWhere(['legal_id' => $legal_id])
            ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->all();

        $stays = ReviewStay::find()
            ->andWhere([
                'IN',
                'stay_id',
                Stay::find()->select('id')->andWhere(['legal_id' => $legal_id])
            ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->all();;

        $cars = ReviewCar::find()
            ->andWhere([
                'IN',
                'car_id',
                Car::find()->select('id')->andWhere(['legal_id' => $legal_id])
            ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->all();
        $funs = ReviewFun::find()
            ->andWhere([
                'IN',
                'fun_id',
                Fun::find()->select('id')->andWhere(['legal_id' => $legal_id])
            ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->all();

        return $this->sort_merge($tours, $stays, $cars, $funs);
    }

    /** @return BaseReview[] */
    public function getByUser($user_id): array
    {
        //TODO ** BOOKING_OBJECT **
        $tours = ReviewTour::find()->andWhere(['user_id' => $user_id])->andWhere(['status' => BaseReview::STATUS_ACTIVE])->all();
        $stays = ReviewStay::find()->andWhere(['user_id' => $user_id])->andWhere(['status' => BaseReview::STATUS_ACTIVE])->all();
        $cars = ReviewCar::find()->andWhere(['user_id' => $user_id])->andWhere(['status' => BaseReview::STATUS_ACTIVE])->all();;
        $funs = ReviewFun::find()->andWhere(['user_id' => $user_id])->andWhere(['status' => BaseReview::STATUS_ACTIVE])->all();;
        return $this->sort_merge($tours, $stays, $cars, $funs);
    }

    /** @return BaseReview[] */
    public function getByAdmin($admin_id, $last_day = 7): array
    {
        //TODO ** BOOKING_OBJECT **
        $old = time() - 3600 * 24 * $last_day;
        $tours = ReviewTour::find()->andWhere([
            'IN',
            'tour_id',
            Tour::find()->select('id')->andWhere(['user_id' => $admin_id])
        ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->andWhere(['>=', 'created_at', $old])
            ->orderBy(['created_at' => SORT_DESC])->all();
        $stays = ReviewStay::find()->andWhere([
            'IN',
            'stay_id',
            Stay::find()->select('id')->andWhere(['user_id' => $admin_id])
        ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->andWhere(['>=', 'created_at', $old])
            ->orderBy(['created_at' => SORT_DESC])->all();

        $cars = ReviewCar::find()->andWhere([
            'IN',
            'car_id',
            Car::find()->select('id')->andWhere(['user_id' => $admin_id])
        ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->andWhere(['>=', 'created_at', $old])
            ->orderBy(['created_at' => SORT_DESC])->all();
        $funs = ReviewFun::find()->andWhere([
            'IN',
            'fun_id',
            Fun::find()->select('id')->andWhere(['user_id' => $admin_id])
        ])
            ->andWhere(['status' => BaseReview::STATUS_ACTIVE])
            ->andWhere(['>=', 'created_at', $old])
            ->orderBy(['created_at' => SORT_DESC])->all();

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