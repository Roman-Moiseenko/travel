<?php


namespace booking\repositories\booking;


use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\tours\BookingTour;
use booking\helpers\BookingHelper;
use booking\helpers\scr;

class BookingRepository
{


    //TODO Возвращает массив  всех interface BookingItemInterface
    // Актуальные ()
    // Прошедшие ()
    /** @return  BookingItemInterface[] */
    public function getActive($user_id): array
    {
        $result = [];
        $tours = BookingTour::find()->andWhere(['user_id' => $user_id])->all();
        /** @var BookingTour $tour */
        //scr::p($tours);
        foreach ($tours as $tour) {
            if ($tour->getDate() >= time()) {
                $result[] = $tour;
            }
        }
 /*
        $stays = BookingStay::find()->andWhere(['user_id' => $user_id]);
        foreach ($stays as $stay) {
            if ($stay->getDate() > time() + 3600 * 24) {
                $result[] = $stay;
            }
        }

        $cars = BookingCar::find()->andWhere(['user_id' => $user_id]);
        foreach ($cars as $car) {
            if ($cars->getDate() > time() + 3600 * 24) {
                $result[] = $stay;
            }
        } */

        //TODO Сортировка массива
        return $result;
    }

    /** @return  BookingItemInterface[] */
    public function getPast($user_id): array
    {
        $result = [];
        $tours = BookingTour::find()->andWhere(['user_id' => $user_id])->all();
        /** @var BookingTour $tour */
        //scr::p($tours);
        foreach ($tours as $tour) {
            if ($tour->getDate() < time()) {
                /** Заглушка для не отмененных бронирований */
                if ($tour->getStatus() === BookingHelper::BOOKING_STATUS_NEW) $tour->setStatus(BookingHelper::BOOKING_STATUS_CANCEL);
                $result[] = $tour;
            }
        }
        //TODO Сортировка массива


        return $result;
    }
}