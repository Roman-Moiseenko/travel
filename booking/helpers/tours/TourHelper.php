<?php


namespace booking\helpers\tours;


use booking\entities\booking\AgeLimit;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Extra;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\BookingHelper;

class TourHelper
{
    public static function listPrivate(): array
    {
        return [
            0 => Lang::t('Групповой'),
            1 => Lang::t('Индивидуальный')
        ];
    }

    public static function stringPrivate($private): string
    {
        if ($private === null) return Lang::t('Не задано');
        $arr = TourHelper::listPrivate();
        return $arr[$private];
    }

    public static function listExtra(): array
    {
        return Extra::find()->andWhere(['user_id' => \Yii::$app->user->id])->all();
    }

    public static function group($min, $max)
    {
        if ($min === null && $max === null) return Lang::t('Кол-во в группе неограничено');
        if ($min === null && $max !== null) return Lang::t('Не более') . ' ' . $max . ' ' . Lang::t(' человек');
        if ($min !== null && $max === null) return Lang::t('Не менее') . ' ' . $max . ' ' . Lang::t(' человек');
        return Lang::t('От') . ' ' . $min . ' ' . Lang::t('до') . ' ' . $max . ' ' .Lang::t('человек');
    }

    public static function getCountActiveBooking($tour_id): int
    {
        $bookings = BookingTour::find()->andWhere(['IN', 'status', [
            BookingHelper::BOOKING_STATUS_NEW,
            BookingHelper::BOOKING_STATUS_PAY,
            BookingHelper::BOOKING_STATUS_CONFIRMATION,
        ]
        ])
            ->andWhere(
                [
                    'IN',
                    'calendar_id',
                    CostCalendar::find()->select('id')->andWhere(['tours_id' => $tour_id])->andWhere(['>=', 'tour_at', time()])
                ]
            )
            ->all();
        $count = 0;
        foreach ($bookings as $booking) {
            $count += $booking->quantity();
        }
        return $count;
    }

    public static function getCountReview($tour_id): int
    {
        return ReviewTour::find()->andWhere(['tour_id' => $tour_id])->count();
    }
}