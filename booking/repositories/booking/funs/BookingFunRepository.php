<?php


namespace booking\repositories\booking\funs;


use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\CostCalendar;
use booking\entities\Lang;
use booking\helpers\BookingHelper;

class BookingFunRepository
{
    public function get($id): BookingFun
    {
        return BookingFun::findOne($id);
    }

    public function getByUser($user_id): array
    {
        return BookingFun::find()->andWhere(['user_id' => $user_id])->all();
    }

    public function getByFun($fun_id): array
    {
        return BookingFun::find()->andWhere(
            [
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['fun_id' => $fun_id])
            ]
        )->all();
    }

    public function getNotPay($day): array
    {
        return BookingFun::find()->andWhere(['status' => BookingHelper::BOOKING_STATUS_NEW])->andWhere(['<=', 'created_at', time() - $day * 3600 * 24])->all();
    }

    public function getActiveByFun($fun_id, $only_pay = false): array
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

        $result = BookingFun::find()->andWhere($status)->andWhere(
            [
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['fun_id' => $fun_id])->andWhere(['>=', 'fun_at', time()])
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

    public function getforChart($fun_id, $month, $year, $status): array
    {
        $result = [];
        if ($month == 0) {
            for ($i = 1; $i <= 12; $i++) {
                $begin = strtotime('01-' . $i . '-' . $year . ' 00:00:00');
                $t = date('t', $begin);
                $end = strtotime($t .'-' . $i . '-' . $year . ' 23:59:59');
                $query = BookingFun::find()
                    ->alias('b')
                    ->leftJoin(CostCalendar::tableName() . ' c', 'b.calendar_id = c.id')
                    ->andWhere(['>=', 'c.fun_at', $begin])
                    ->andWhere(['<=', 'c.fun_at', $end]);
                if ($status) $query = $query->andWhere(['b.status' => $status]);
                $result[] = $query->sum('b.count_adult + b.count_child + b.count_preference') ?? 0;
            }
        } else {
            $t = date('t', strtotime('01-' . $month . '-' . $year));
            for ($i = 1; $i <= $t; $i++) {
                $begin = strtotime($i .'-' . $month . '-' . $year . ' 00:00:00');
                $end = strtotime($i . '-' . $month . '-' . $year . ' 23:59:59');
                $query = BookingFun::find()
                    ->alias('b')
                    ->leftJoin(CostCalendar::tableName() . ' c', 'b.calendar_id = c.id')
                    ->andWhere(['>=', 'c.fun_at', $begin])
                    ->andWhere(['<=', 'c.fun_at', $end]);
                if ($status) $query = $query->andWhere(['b.status' => $status]);
                $result[] = $query->sum('b.count_adult + b.count_child + b.count_preference') ?? 0;
            }
        }
        return $result;
    }

    public function save(BookingFun $booking)
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