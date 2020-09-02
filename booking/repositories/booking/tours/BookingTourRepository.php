<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\Lang;
use booking\helpers\BookingHelper;

class BookingTourRepository
{
    public function get($id): BookingTour
    {
        return BookingTour::findOne($id);
    }

    public function getByUser($user_id): array
    {
        return BookingTour::find()->andWhere(['user_id' => $user_id])->all();
    }

    public function getByTours($tours_id): array
    {
        return BookingTour::find()->andWhere(
            [
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['tours_id' => $tours_id])
            ]
        )->all();
    }

    public function getActiveByTour($tours_id, $only_pay = false): array
    {
        if ($only_pay) {
            $status = ['status' => BookingHelper::BOOKING_STATUS_PAY];
        } else {
            $status = ['IN', 'status', [
                BookingHelper::BOOKING_STATUS_NEW,
                BookingHelper::BOOKING_STATUS_PAY
            ]];
        }

        $result = BookingTour::find()->andWhere($status)->andWhere(
            [
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['tours_id' => $tours_id])->andWhere(['>=', 'tour_at', time()])
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


    public function save(BookingTour $booking)
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