<?php


namespace booking\repositories\booking;


use booking\entities\admin\Legal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\BookingCarOnDay;
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
                ->joinWith('calendars c')
                ->andWhere(['c.fun_at' => $this->today()])
                ->andWhere(['f.fun_id' => $object_id])
                ->andWhere(['IN', 'f.status', [BookingHelper::BOOKING_STATUS_PAY, BookingHelper::BOOKING_STATUS_CONFIRMATION]])
                ->orderBy(['f.give_out' => SORT_ASC])
                ->groupBy('f.id')
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
            ->joinWith('calendars c')
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
            ->andWhere(['<', 'c.tour_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        $cars = BookingCar::find()
            ->andWhere(['<', 'begin_at', time()])
            ->andWhere(['user_id' => $user_id])
            ->all();
        $funs = BookingFun::find()
            ->joinWith('calendars c')
            ->andWhere(['<', 'c.fun_at', time()])
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
            ->andWhere(['>=', 'begin_at', time()])
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

        $funs = BookingFun::find()->alias('f')
            ->joinWith('calendars c')
            ->andWhere(['>=', 'c.fun_at', time()])
            ->andWhere(
                [
                    'IN',
                    'f.fun_id',
                    Fun::find()->select('id')->andWhere(['user_id' => $admin_id])
                ]
            )
            ->andWhere([
                'IN',
                'f.status', [
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

    public function getforChart($object, int $month, int $year, $status)
    {
        $result = [];
        //TODO Заглушка Stay
        if ($month == 0) {
            for ($i = 1; $i <= 12; $i++) {
                $begin = strtotime('01-' . $i . '-' . $year . ' 00:00:00');
                $t = date('t', $begin);
                $end = strtotime($t . '-' . $i . '-' . $year . ' 23:59:59');
                if (get_class($object) == Tour::class) $result[] = $this->sumBookingTour($begin, $end, $status, $object->id);
                if (get_class($object) == Fun::class) $result[] = $this->sumBookingFun($begin, $end, $status, $object->id);
                if (get_class($object) == Car::class) $result[] = $this->sumBookingCar($begin, $end, $status, $object->id);
            }
        } else {
            $t = date('t', strtotime('01-' . $month . '-' . $year));
            for ($i = 1; $i <= $t; $i++) {
                $begin = strtotime($i . '-' . $month . '-' . $year . ' 00:00:00');
                $end = strtotime($i . '-' . $month . '-' . $year . ' 23:59:59');
                if (get_class($object) == Tour::class) $result[] = $this->sumBookingTour($begin, $end, $status, $object->id);
                if (get_class($object) == Fun::class) $result[] = $this->sumBookingFun($begin, $end, $status, $object->id);
                if (get_class($object) == Car::class) $result[] = $this->sumBookingCar($begin, $end, $status, $object->id);
            }
        }
        return $result;
    }

    private function sumBookingFun($begin, $end, $status, $fun_id): int
    {
        //TODO Возможно ошибочни считает
        $query = BookingFun::find()
            ->alias('b')
            ->joinWith('calendars c')
            ->andWhere(['b.fun_id' => $fun_id])
            ->andWhere(['>=', 'c.fun_at', $begin])
            ->andWhere(['<=', 'c.fun_at', $end]);
        if ($status) $query = $query->andWhere(['IN', 'b.status',  $status]);
        return $query->sum('b.count_adult + b.count_child + b.count_preference') ?? 0;
    }

    private function sumBookingTour($begin, $end, $status, $tour_id): int
    {
        $query = BookingTour::find()
            ->alias('b')
            ->leftJoin(CostCalendar::tableName() . ' c', 'b.calendar_id = c.id')
            ->andWhere(['c.tours_id' => $tour_id])
            ->andWhere(['>=', 'c.tour_at', $begin])
            ->andWhere(['<=', 'c.tour_at', $end]);
        if ($status) $query = $query->andWhere(['IN', 'b.status',  $status]);
        return $query->sum('b.count_adult + b.count_child + b.count_preference') ?? 0;
    }

    private function sumBookingCar($begin, $end, $status, $car_id): int
    {
        $query = \booking\entities\booking\cars\CostCalendar::find()
            ->alias('c')
            ->andWhere(['c.car_id' => $car_id])
            ->andWhere(['>=', 'c.car_at', $begin])
            ->andWhere(['<=', 'c.car_at', $end])
            ->leftJoin(BookingCarOnDay::tableName() . ' d', 'd.calendar_id = c.id')
            ->leftJoin(BookingCar::tableName() . ' b', 'b.id = d.booking_id');
        if ($status) $query = $query->andWhere(['IN', 'b.status',  $status]);
        return $query->sum('b.count') ?? 0;
    }

    public function getforChartAmount($object, int $month, int $year)
    {
        $result = [];
        //TODO Заглушка Stay
        if ($month == 0) {
            for ($i = 1; $i <= 12; $i++) {
                $begin = strtotime('01-' . $i . '-' . $year . ' 00:00:00');
                $t = date('t', $begin);
                $end = strtotime($t . '-' . $i . '-' . $year . ' 23:59:59');
                if (get_class($object) == Tour::class) $result[] = $this->sumBookingTourAmount($begin, $end, $object->id);
                if (get_class($object) == Fun::class) $result[] = $this->sumBookingFunAmount($begin, $end, $object->id);
                if (get_class($object) == Car::class) $result[] = $this->sumBookingCarAmount($begin, $end, $object->id);
            }
        } else {
            $t = date('t', strtotime('01-' . $month . '-' . $year));
            for ($i = 1; $i <= $t; $i++) {
                $begin = strtotime($i . '-' . $month . '-' . $year . ' 00:00:00');
                $end = strtotime($i . '-' . $month . '-' . $year . ' 23:59:59');
                if (get_class($object) == Tour::class) $result[] = $this->sumBookingTourAmount($begin, $end, $object->id);
                if (get_class($object) == Fun::class) $result[] = $this->sumBookingFunAmount($begin, $end, $object->id);
                if (get_class($object) == Car::class) $result[] = $this->sumBookingCarAmount($begin, $end, $object->id);
            }
        }
        return $result;
    }
    private function sumBookingFunAmount($begin, $end, $fun_id): int
    {
        $result = 0;
        $bookings = BookingFun::find()
            ->andWhere(['fun_id' => $fun_id])
            ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])->all();

        foreach ($bookings as $booking) {
            if ($begin <= $booking->getDate() && $booking->getDate() <= $end) {
                $result += $booking->payment_provider;
            }
        }
        return $result;
    }

    private function sumBookingTourAmount($begin, $end, $tour_id): int
    {
        $query = BookingTour::find()
            ->alias('b')
            ->leftJoin(CostCalendar::tableName() . ' c', 'b.calendar_id = c.id')
            ->andWhere(['c.tours_id' => $tour_id])
            ->andWhere(['>=', 'c.tour_at', $begin])
            ->andWhere(['<=', 'c.tour_at', $end])
            ->andWhere(['b.status' => BookingHelper::BOOKING_STATUS_PAY]);

        return $query->sum('b.payment_provider') ?? 0;
    }

    private function sumBookingCarAmount($begin, $end, $car_id): int
    {
        $query = BookingCar::find()
            ->andWhere(['car_id' => $car_id])
            ->andWhere(['>=', 'begin_at', $begin])
            ->andWhere(['<=', 'begin_at', $end])
            ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY]);
        return $query->sum('payment_provider') ?? 0;

        /*
        $query = \booking\entities\booking\cars\CostCalendar::find()
            ->alias('b')
            ->andWhere(['c.car_id' => $car_id])
            ->andWhere(['>=', 'c.car_at', $begin])
            ->andWhere(['<=', 'c.car_at', $end])
            ->leftJoin(BookingCarOnDay::tableName() . ' d', 'd.calendar_id = c.id')
            ->leftJoin(BookingCar::tableName() . ' b', 'b.id = d.booking_id')
            ->andWhere(['b.status' => BookingHelper::BOOKING_STATUS_PAY]);
        return $query->sum('b.payment_provider') ?? 0;
         */
    }
}