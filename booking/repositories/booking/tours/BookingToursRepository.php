<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\BookingTours;
use booking\entities\Lang;

class BookingToursRepository
{
    public function get($id): BookingTours
    {
        return BookingTours::findOne($id);
    }

    public function getByUser($user_id): array
    {
        return BookingTours::find()->andWhere(['user_id' => $user_id])->all();
    }

    public function getByTours($tours_id): array
    {
        //TODO
    }


    public function save(BookingTours $booking)
    {
        if (!$booking->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения бронирования'));
        }
    }

    //TODO delete

}