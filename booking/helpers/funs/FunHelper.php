<?php


namespace booking\helpers\funs;


use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Extra;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\ReviewFun;
use booking\helpers\BookingHelper;
use booking\helpers\scr;

class FunHelper
{

    public static function listExtra(): array
    {
        return Extra::find()->andWhere(['user_id' => \Yii::$app->user->id])->all();
    }

    public static function getCountActiveBooking($fun_id): int
    {
        $bookings = BookingFun::find()->alias('f')
            ->joinWith('calendars c')
            ->andWhere(['f.object_id' => $fun_id])
            ->andWhere(['>=', 'c.fun_at', time()])
            ->andWhere(
                [
                    'IN',
                    'f.status',
                    [
                        BookingHelper::BOOKING_STATUS_NEW,
                        BookingHelper::BOOKING_STATUS_PAY,
                        BookingHelper::BOOKING_STATUS_CONFIRMATION,
                    ]
                ])
            ->all();
        $count = 0;
        foreach ($bookings as $booking) {
            $count += $booking->quantity();
        }
        return $count;
    }

    public static function getCountReview($fun_id): int
    {
        return ReviewFun::find()->andWhere(['fun_id' => $fun_id])->count();
    }
}