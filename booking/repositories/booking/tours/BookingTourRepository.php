<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\Lang;

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