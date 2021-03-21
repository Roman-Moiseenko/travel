<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\stays\CostCalendar;
use booking\entities\Lang;
use booking\helpers\BookingHelper;

class BookingStayRepository
{
    public function get($id): BookingStay
    {
        return BookingStay::findOne($id);
    }

    public function getByUser($user_id): array
    {
        return BookingStay::find()->andWhere(['user_id' => $user_id])->all();
    }

    public function getByCalendar($calendar_id)
    {
        return BookingStay::find()->andWhere(['calendar_id' => $calendar_id])->all();
    }

    public function getByStay($stay_id): array
    {
        return BookingStay::find()->andWhere(
            [
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['stay_id' => $stay_id])
            ]
        )->all();
    }

    public function getNotPay($day): array
    {
        return BookingStay::find()->andWhere(['status' => BookingHelper::BOOKING_STATUS_NEW])->andWhere(['<=', 'created_at', time() - $day * 3600 * 24])->all();
    }

    public function getActiveByStay($stay_id, $only_pay = false): array
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

        $result = BookingStay::find()->andWhere($status)->andWhere(
            [
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['stay_id' => $stay_id])->andWhere(['>=', 'stay_at', time()])
            ]
        )
            ->all();

        usort($result, function ($a, $b) {
            if ($a->getDate() == $b->getDate()) {
                if ($a->getAdd() > $b->getAdd()) {
                    return 1;
                } else {
                    return -1;
                }
            }
            if ($a->getDate() > $b->getDate()) {
                return 1;
            } else {
                return -1;
            }
        });
        return $result;
    }

    public function getforChart($tour_id, $month, $year, $status): array
    {
        $result = [];
        if ($month == 0) {
            for ($i = 1; $i <= 12; $i++) {
                $begin = strtotime('01-' . $i . '-' . $year . ' 00:00:00');
                $t = date('t', $begin);
                $end = strtotime($t .'-' . $i . '-' . $year . ' 23:59:59');
                $query = BookingStay::find()
                    ->alias('b')
                    ->leftJoin(CostCalendar::tableName() . ' c', 'b.calendar_id = c.id')
                    ->andWhere(['c.stay_id' => $tour_id])
                    ->andWhere(['>=', 'c.stay_at', $begin])
                    ->andWhere(['<=', 'c.stay_at', $end]);
                if ($status) $query = $query->andWhere(['b.status' => $status]);
                $result[] = $query->sum('b.guest') ?? 0;
            }
        } else {
            $t = date('t', strtotime('01-' . $month . '-' . $year));
            for ($i = 1; $i <= $t; $i++) {
                $begin = strtotime($i .'-' . $month . '-' . $year . ' 00:00:00');
                $end = strtotime($i . '-' . $month . '-' . $year . ' 23:59:59');
                $query = BookingStay::find()
                    ->alias('b')
                    ->leftJoin(CostCalendar::tableName() . ' c', 'b.calendar_id = c.id')
                    ->andWhere(['c.stay_id' => $tour_id])
                    ->andWhere(['>=', 'c.stay_at', $begin])
                    ->andWhere(['<=', 'c.stay_at', $end]);
                if ($status) $query = $query->andWhere(['b.status' => $status]);
                $result[] = $query->sum('b.guest') ?? 0;
            }
        }
        return $result;
    }

    public function save(BookingStay $booking)
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