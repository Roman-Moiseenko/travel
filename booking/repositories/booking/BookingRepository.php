<?php


namespace booking\repositories\booking;


use booking\entities\admin\user\UserLegal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Tour;
use booking\helpers\scr;

class BookingRepository
{
    /** @return  BookingItemInterface[] */
    public function getActive($user_id): array
    {
        $result = [];
        $tours = BookingTour::find()
            ->joinWith('calendar c')
            ->where(['>=', 'c.tour_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        /*     $stays = BookingStay::find()
                   ->joinWith('calendar c')
                   ->where(['>=', 'c.stay_at', time()])
                   ->andWhere(['user_id' => $user_id])
                   ->all();
               $cars = BookingCar::find()
                   ->joinWith('calendar c')
                   ->where(['>=', 'c.car_at', time()])
                   ->andWhere(['user_id' => $user_id])
                   ->all();*/
        $stays = [];
        $cars = [];
        return $this->sort_merge($tours, $stays, $cars);
    }

    /** @return  BookingItemInterface[] */
    public function getPast($user_id): array
    {
        $tours = BookingTour::find()
            ->joinWith('calendar c')
            ->where(['<', 'c.tour_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        $stays = [];
        $cars = [];

        return $this->sort_merge($tours, $stays, $cars, -1);
    }

    /** @return  BookingItemInterface[] */
    public function getByAdmin($admin_id, $last_day = 1): array
    {
        $tours = BookingTour::find()
            ->andWhere(['>=', 'created_at', time() - 3600 * 24 * $last_day])
            ->andWhere(
                [
                    'IN',
                    'calendar_id',
                    CostCalendar::find()->select('id')->andWhere(
                        [
                            'IN',
                            'tours_id',
                            Tour::find()->select('id')->andWhere(
                                [
                                    'IN',
                                    'legal_id',
                                    UserLegal::find()->select('id')->andWhere(['user_id' => $admin_id])
                                ]
                            )
                        ]
                    )
                ]
            )
            ->all();
        $stays = [];
        $cars = [];

        return $this->sort_merge($tours, $stays, $cars, -1);
    }

    private function sort_merge(array $tours, array $stays, array $cars, $arrow = 1): array
    {
        $result = array_merge($tours, $stays, $cars);
        usort($result, function (BookingItemInterface $a, BookingItemInterface $b) use ($arrow) {
            if ($a->getDate() > $b->getDate()) {
                return $arrow;
            } else {
                return -1 * $arrow;
            }
        });
        return $result;
    }
}