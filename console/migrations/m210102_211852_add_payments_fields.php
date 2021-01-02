<?php

use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\tours\BookingTour;
use booking\helpers\BookingHelper;
use yii\db\Migration;

/**
 * Class m210102_211852_add_payments_fields
 */
class m210102_211852_add_payments_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_at', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_merchant', $this->float());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_deduction', $this->float());

        $this->addColumn('{{%booking_cars_calendar_booking}}', 'payment_at', $this->integer());
        $this->addColumn('{{%booking_cars_calendar_booking}}', 'payment_merchant', $this->float());
        $this->addColumn('{{%booking_cars_calendar_booking}}', 'payment_deduction', $this->float());

        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_at', $this->integer());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_merchant', $this->float());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_deduction', $this->float());

        $bookings = BookingTour::find()->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])->all();
        foreach ($bookings as $booking) {
            $booking->payment_merchant = $booking->getAmount() * (1 - \Yii::$app->params['merchant']);
            $booking->payment_deduction = $booking->getAmount() * (1 - \Yii::$app->params['deduction']);
            $booking->payment_at = time();
            $booking->save();
        }

        $bookings = BookingFun::find()->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])->all();
        foreach ($bookings as $booking) {
            $booking->payment_merchant = $booking->getAmount() * (1 - \Yii::$app->params['merchant']);
            $booking->payment_deduction = $booking->getAmount() * (1 - \Yii::$app->params['deduction']);
            $booking->payment_at = time();
            $booking->save();
        }
        $bookings = BookingCar::find()->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])->all();
        foreach ($bookings as $booking) {
            $booking->payment_merchant = $booking->getAmount() * (1 - \Yii::$app->params['merchant']);
            $booking->payment_deduction = $booking->getAmount() * (1 - \Yii::$app->params['deduction']);
            $booking->payment_at = time();
            $booking->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_at');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_merchant');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_deduction');

        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'payment_at');
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'payment_merchant');
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'payment_deduction');

        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_at');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_merchant');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_deduction');
    }

}
