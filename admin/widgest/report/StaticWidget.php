<?php


namespace admin\widgest\report;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use yii\base\Widget;

class StaticWidget extends Widget
{

    public $object;

    public function run()
    {
        $views = $this->object->views;
        $next_amount = 0;
        $last_tickets = 0;
        $last_amount = 0;
        $now = strtotime(date('d-m-Y', time()) . ' 00:00:00');
        if (get_class($this->object) == Tour::class) {
            $next_amount = BookingTour::find()->alias('b')
                ->joinWith('calendar c')
                ->andWhere(['b.status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['c.tours_id' => $this->object->id])
                ->andWhere(['>=', 'c.tour_at', $now])->sum('b.payment_provider');
            $last_amount = BookingTour::find()->alias('b')
                ->joinWith('calendar c')
                ->andWhere(['b.status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['c.tours_id' => $this->object->id])
                ->andWhere(['<', 'c.tour_at', $now])->sum('b.payment_provider');
            $last_tickets = BookingTour::find()->alias('b')
                ->joinWith('calendar c')
                ->andWhere(['b.status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['c.tours_id' => $this->object->id])
                ->andWhere(['<', 'c.tour_at', $now])->sum('b.count_adult + b.count_child + b.count_preference');
        }

        if (get_class($this->object) == Car::class) {
            $next_amount = BookingCar::find()
                ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['car_id' => $this->object->id])
                ->andWhere(['>=', 'begin_at', $now])
                ->sum('payment_provider');
            $last_amount = BookingCar::find()
                ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['car_id' => $this->object->id])
                ->andWhere(['<', 'begin_at', $now])
                ->sum('payment_provider');
            $last_tickets = BookingCar::find()->alias('b')
                ->joinWith('calendars c')
                ->andWhere(['b.status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['b.car_id' => $this->object->id])
                ->andWhere(['<', 'c.car_at', $now])
                ->sum('b.count');
        }

        if (get_class($this->object) == Fun::class) {
            $bookings = BookingFun::find()
                ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['fun_id' => $this->object->id])->all();
            $next_amount = 0;
            $last_amount = 0;
            foreach ($bookings as $booking) {
                if ($booking->getDate() < $now) {
                    $last_amount += $booking->payment_provider;
                } else {
                    $next_amount += $booking->payment_provider;
                }
            }
            $last_tickets = BookingFun::find()->alias('b')
                ->joinWith('calendars c')
                ->andWhere(['b.status' => BookingHelper::BOOKING_STATUS_PAY])
                ->andWhere(['b.fun_id' => $this->object->id])
                ->andWhere(['<', 'c.fun_at', $now])
                ->sum('b.count_adult + b.count_child + b.count_preference');
        }

        return $this->render('static', [
            'views' => $views,
            'next_amount' => $next_amount,
            'last_tickets' => $last_tickets,
            'last_amount' => $last_amount,
        ]);
    }
}