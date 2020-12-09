<?php


namespace booking\repositories\booking;


use booking\entities\admin\Legal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\helpers\scr;

class BookingRepository
{
    /** @return  BookingItemInterface[] */
    public function getTodayCheck($object_class, $object_id): array
    {

        if ($object_class == BookingTour::class) {
            $bookings = BookingTour::find()->alias('b')
                ->joinWith('calendar c')
                ->andWhere(['c.tour_at' => $this->today()])
                ->andWhere(['c.tours_id' => $object_id])
                ->andWhere(['IN', 'b.status', [BookingHelper::BOOKING_STATUS_PAY, BookingHelper::BOOKING_STATUS_CONFIRMATION]])
                ->orderBy(['b.give_out' => SORT_ASC])
                ->all();
            return $bookings;
        }
        if ($object_class == BookingCar::class) {
            $bookings = BookingCar::find()
                ->andWhere(['begin_at' => $this->today()])
                ->andWhere(['car_id' => $object_id])
                ->andWhere(['IN', 'status', [BookingHelper::BOOKING_STATUS_PAY, BookingHelper::BOOKING_STATUS_CONFIRMATION]])
                ->orderBy(['give_out' => SORT_ASC])
                ->all();
            return $bookings;
        }
        if ($object_class == BookingFun::class) {
            $bookings = BookingFun::find()->alias('f')
                ->joinWith('calendar c')
                ->andWhere(['c.fun_at' => $this->today()])
                ->andWhere(['c.fun_id' => $object_id])
                ->andWhere(['IN', 'f.status', [BookingHelper::BOOKING_STATUS_PAY, BookingHelper::BOOKING_STATUS_CONFIRMATION]])
                ->orderBy(['f.give_out' => SORT_ASC])
                ->all();
            return $bookings;
        }

        //TODO Заглушка Stay
        return [];
    }

    /** @return  BookingItemInterface[] */
    public function getActive($user_id): array
    {
        $result = [];
        $tours = BookingTour::find()
            ->joinWith('calendar c')
            ->where(['>=', 'c.tour_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        $cars = BookingCar::find()
            ->where(['>=', 'begin_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        $funs = BookingFun::find()->alias('f')
            ->joinWith('calendar c')
            ->where(['>=', 'c.fun_at', time()])
            ->andWhere(['f.user_id' => $user_id])
            ->all();

        //TODO Заглушка Stay
        $stays = [];

        return $this->sort_merge($tours, $stays, $cars, $funs);
    }

    /** @return  BookingItemInterface[] */
    public function getPast($user_id): array
    {
        $tours = BookingTour::find()
            ->joinWith('calendar c')
            ->where(['<', 'c.tour_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        $cars = BookingCar::find()
            ->where(['<', 'begin_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        $funs = BookingFun::find()
            ->joinWith('calendar c')
            ->where(['<', 'c.fun_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();

        //TODO Заглушка Stay
        $stays = [];

        return $this->sort_merge($tours, $stays, $cars, $funs, -1);
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
                            Tour::find()->select('id')->andWhere(['user_id' => $admin_id])
                        ]
                    )
                ]
            )
            ->all();
        $cars = BookingCar::find()
            ->andWhere(['>=', 'created_at', time() - 3600 * 24 * $last_day])
            ->andWhere([
                'IN',
                'car_id',
                Car::find()->select('id')->andWhere(['user_id' => $admin_id])
            ])
            ->all();

        $funs = BookingFun::find()
            ->andWhere(['>=', 'created_at', time() - 3600 * 24 * $last_day])
            ->andWhere(
                [
                    'IN',
                    'fun_id',
                    Fun::find()->select('id')->andWhere(['user_id' => $admin_id])
                ]
            )
            ->all();

        //TODO Заглушка Stay
        $stays = [];
        return $this->sort_merge($tours, $stays, $cars, $funs, -1);
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
                                Tour::find()->select('id')->andWhere(['user_id' => $admin_id])
                            ]
                        )
                        ->andWhere(['>=', 'tour_at', time()])
                ]
            )
            ->andWhere([
                'IN',
                'status', [
                    BookingHelper::BOOKING_STATUS_NEW,
                    BookingHelper::BOOKING_STATUS_PAY,
                    BookingHelper::BOOKING_STATUS_CONFIRMATION,
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
        }

        $cars = BookingCar::find()
            ->andWhere([
                'IN',
                'car_id',
                Car::find()->select('id')
                    ->andWhere(['user_id' => $admin_id])
            ])
            ->andWhere([
                'IN',
                'status', [
                    BookingHelper::BOOKING_STATUS_NEW,
                    BookingHelper::BOOKING_STATUS_PAY,
                    BookingHelper::BOOKING_STATUS_CONFIRMATION,
                ]
            ])
            ->all();
        foreach ($cars as $car) {
            $result[$car->getName()] = [
                'photo' => $car->getPhoto('cars_widget_list'),
                'link' => $car->getLinks()['booking'],
                'name' => $car->getName(),
                'count' => $car->count + (isset($result[$car->getName()]) ? $result[$car->getName()]['count'] : 0),
            ];
        }

        $funs = BookingFun::find()
            ->andWhere(
                [
                    'IN',
                    'calendar_id',
                    \booking\entities\booking\funs\CostCalendar::find()->select('id')
                        ->andWhere(
                            [
                                'IN',
                                'fun_id',
                                Fun::find()->select('id')->andWhere(['user_id' => $admin_id])
                            ]
                        )
                        ->andWhere(['>=', 'fun_at', time()])
                ]
            )
            ->andWhere([
                'IN',
                'status', [
                    BookingHelper::BOOKING_STATUS_NEW,
                    BookingHelper::BOOKING_STATUS_PAY,
                    BookingHelper::BOOKING_STATUS_CONFIRMATION,
                ]
            ])
            ->all();
        foreach ($funs as $fun) {
            $result[$fun->getName()] = [
                'photo' => $fun->getPhoto('funs_widget_list'),
                'link' => $fun->getLinks()['booking'],
                'name' => $fun->getName(),
                'count' => $fun->countTickets() + (isset($result[$fun->getName()]) ? $result[$fun->getName()]['count'] : 0),
            ];
        }

        //TODO Заглушка Stay
        $stays = [];

        return $result; // $this->sort_merge($tours, $stays, $cars, -1);
    }

    private function sort_merge(array $tours, array $stays, array $cars, array $funs, $arrow = 1): array
    {
        $result = array_merge($tours, $stays, $cars, $funs);
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

        //TODO Заглушка Stay
        //$result = BookingStay::find()->andWhere(['payment_id' => $payment_id])->one();
        //if (!empty($result)) return $result;

        $result = BookingCar::find()->andWhere(['payment_id' => $payment_id])->one();
        if ($result) return $result;

        $result = BookingFun::find()->andWhere(['payment_id' => $payment_id])->one();
        if ($result) return $result;
    }

    private function today()
    {
        return strtotime(date('d-m-Y', time()) . ' 00:00:00');
    }
}