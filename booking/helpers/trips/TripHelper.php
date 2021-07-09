<?php


namespace booking\helpers\trips;


use booking\entities\booking\trips\BookingTrip;
use booking\entities\booking\trips\ReviewTrip;
use booking\entities\land\Land;
use booking\entities\Lang;
use booking\helpers\BookingHelper;

class TripHelper
{
    //TODO Убрать заглушки!!!!!!!!!!!!
    public static function getCountActiveBooking($tour_id): int
    {
        return 0;
        /*
        $bookings = BookingTrip::find()->andWhere(['IN', 'status', [
            BookingHelper::BOOKING_STATUS_NEW,
            BookingHelper::BOOKING_STATUS_PAY,
            BookingHelper::BOOKING_STATUS_CONFIRMATION,
        ]
        ])
            ->andWhere(
                [
                    'IN',
                    'calendar_id',
                    CostCalendar::find()->select('id')->andWhere(['trip_id' => $tour_id])->andWhere(['>=', 'trip_at', time()])
                ]
            )
            ->all();
        $count = 0;
        foreach ($bookings as $booking) {
            $count += $booking->quantity();
        }
        return $count;*/
    }

    public static function getCountReview($trip_id): int
    {
        return 0;
        //return ReviewTrip::find()->andWhere(['trip_id' => $trip_id])->count();
    }

    public static function duration($duration)
    {
        return $duration . ' ' . Lang::t('дней') . '/' . ($duration + 1) . ' ' . Lang::t('ночей');
    }
}