<?php


namespace booking\repositories\booking;


use booking\entities\admin\Legal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
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
    public function getByAdminLastCreated($admin_id, $last_day = 1): array
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
                                    Legal::find()->select('id')->andWhere(['user_id' => $admin_id])
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

    public function getByAdminNextDay($admin_id): array
    {
        $result = [];
        $tours = BookingTour::find()
            ->andWhere(
                [
                    'IN',
                    'calendar_id',
                    CostCalendar::find()->select('id')
                        ->andWhere(
                            [
                                'IN',
                                'tours_id',
                                Tour::find()->select('id')->andWhere(
                                    [
                                        'IN',
                                        'legal_id',
                                        Legal::find()->select('id')->andWhere(['user_id' => $admin_id])
                                    ]
                                )
                            ]
                        )
                        ->andWhere(['>=', 'tour_at', time()])
                    //  ->andWhere(['<=', 'tour_at', time() + 24 * 3600 * $days])
                ]
            )
            ->andWhere([
                'IN',
                'status', [
                    BookingHelper::BOOKING_STATUS_NEW,
                    BookingHelper::BOOKING_STATUS_PAY
                ]
            ])
            ->all();
        foreach ($tours as $tour) {
            $result[$tour->getName()] = [
                'photo' => $tour->getPhoto('tours_widget_list'),
                'link' => $tour->getLinks()['booking'],
                'name' => $tour->getName(),
                'count' => $tour->countTickets() + (isset($result[$tour->getName()]) ? $result[$tour->getName()]['count'] : 0),
            ];
            /*$result[] = [
                'photo' => $tour->getPhoto('tours_widget_list'),
                'link' => $tour->getLinks()['admin'],
                'name' => $tour->getName(),
                'count' => $tour->countTickets()
                ];
                */
        }
        $stays = [];
        $cars = [];

        return $result; // $this->sort_merge($tours, $stays, $cars, -1);
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
        /** @var BookingItemInterface $booking */
        foreach ($result as $booking) {
            if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_NEW && (time() - $booking->getCreated() > 3600 * 24)) $booking->setStatus(BookingHelper::BOOKING_STATUS_CANCEL);
        }
        return $result;
    }

    public function getByPaymentId($payment_id): BookingItemInterface
    {
        $result = BookingTour::find()->andWhere(['payment_id' => $payment_id])->one();
        if ($result) return $result;
        $result = BookingStay::find()->andWhere(['payment_id' => $payment_id])->one();
        if ($result) return $result;
        $result = BookingCar::find()->andWhere(['payment_id' => $payment_id])->one();
        if ($result) return $result;
    }
}