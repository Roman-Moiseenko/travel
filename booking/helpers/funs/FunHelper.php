<?php


namespace booking\helpers\funs;


use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Extra;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\ReviewFun;
use booking\helpers\BookingHelper;

class FunHelper
{

    public static function listExtra(): array
    {
        return Extra::find()->andWhere(['user_id' => \Yii::$app->user->id])->all();
    }

    public static function getCountActiveBooking($fun_id): int
    {
        $bookings = BookingFun::find()->andWhere(['IN', 'status', [
            BookingHelper::BOOKING_STATUS_NEW,
            BookingHelper::BOOKING_STATUS_PAY,
            BookingHelper::BOOKING_STATUS_CONFIRMATION,
        ]
        ])
            ->andWhere(
                [
                    'IN',
                    'calendar_id',
                    CostCalendar::find()->select('id')->andWhere(['fun_id' => $fun_id])->andWhere(['>=', 'fun_at', time()])
                ]
            )
            ->all();
        $count = 0;
        foreach ($bookings as $booking) {
            $count += $booking->countTickets();
        }
        return $count;
    }

    public static function getCountReview($fun_id): int
    {
        return ReviewFun::find()->andWhere(['fun_id' => $fun_id])->count();
    }
}