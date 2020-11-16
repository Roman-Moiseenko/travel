<?php


namespace booking\repositories\booking\cars;

use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\BookingCarOnDay;
use booking\entities\booking\cars\CostCalendar;
use booking\entities\Lang;
use booking\helpers\BookingHelper;

class BookingCarRepository
{
    public function get($id): BookingCar
    {
        return BookingCar::findOne($id);
    }

    public function getByUser($user_id): array
    {
        return BookingCar::find()->andWhere(['user_id' => $user_id])->all();
    }

    public function getByCar($car_id): array
    {
        return BookingCar::find()->andWhere(['car_id' => $car_id])->all();
    }

    public function getNotPay($day): array
    {
        return BookingCar::find()->andWhere(['status' => BookingHelper::BOOKING_STATUS_NEW])->andWhere(['<=', 'created_at', time() - $day * 3600 * 24])->all();
    }

    public function getActiveByCar($car_id, $only_pay = false): array
    {
        if ($only_pay) {
            $status = ['IN', 'status', [
                BookingHelper::BOOKING_STATUS_PAY,
                BookingHelper::BOOKING_STATUS_CONFIRMATION,
            ]];
        } else {
            $status = ['IN', 'status', [
                BookingHelper::BOOKING_STATUS_NEW,
                BookingHelper::BOOKING_STATUS_PAY,
                BookingHelper::BOOKING_STATUS_CONFIRMATION,
            ]];
        }

        $bookings = BookingCar::find()
            ->andWhere($status)
            ->andWhere(['car_id' => $car_id])
            //->andWhere(['>=', 'begin_at', time()])
            ->all();
        $result = [];
        foreach ($bookings as $booking) {
            foreach ($booking->days as $day) {
                $y = (int)date('Y', $day->calendar->car_at);
                $m = (int)date('m', $day->calendar->car_at);
                $d = (int)date('d', $day->calendar->car_at);
                $free = $day->calendar->getFreeCount();
                $all = $day->calendar->count;
                $result[$y][$m][$d] = ['free' => $free, 'count' => ($all - $free)];
            }
        }
        return $result;
    }

    public function getforChart($car_id, $month, $year, $status): array
    {
        $result = [];
        if ($month == 0) {
            for ($i = 1; $i <= 12; $i++) {
                $begin = strtotime('01-' . $i . '-' . $year . ' 00:00:00');
                $t = date('t', $begin);
                $end = strtotime($t . '-' . $i . '-' . $year . ' 23:59:59');
                $result[] = $this->sumBookingCar($begin, $end, $status, $car_id);
            }
        } else {
            $t = date('t', strtotime('01-' . $month . '-' . $year));
            for ($i = 1; $i <= $t; $i++) {
                $begin = strtotime($i . '-' . $month . '-' . $year . ' 00:00:00');
                $end = strtotime($i . '-' . $month . '-' . $year . ' 23:59:59');
                $result[] = $this->sumBookingCar($begin, $end, $status, $car_id);
            }
        }
        return $result;
    }

    private function sumBookingCar($begin, $end, $status, $car_id): int
    {
        $query = CostCalendar::find()
            ->alias('c')
            ->andWhere(['c.car_id' => $car_id])
            ->andWhere(['>=', 'c.car_at', $begin])
            ->andWhere(['<=', 'c.car_at', $end])
            ->leftJoin(BookingCarOnDay::tableName() . ' d', 'd.calendar_id = c.id')
            ->leftJoin(BookingCar::tableName() . ' b', 'b.id = d.booking_id');
        if ($status) $query = $query->andWhere(['b.status' => $status]);
        return $query->sum('b.count') ?? 0;
    }


    public function save(BookingCar $booking)
    {
        if (!$booking->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения бронирования'));
        }
    }

    public function remove(int $id)
    {
        $booking = $this->get($id);
        if (!$booking->delete()) {
            throw new \DomainException(Lang::t('Ошибка удаления бронирования'));
        }
    }

}