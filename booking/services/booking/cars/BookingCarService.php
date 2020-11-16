<?php


namespace booking\services\booking\cars;

use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\BookingCarOnDay;
use booking\entities\booking\Discount;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\repositories\booking\cars\BookingCarRepository;
use booking\repositories\booking\cars\CostCalendarRepository;
use booking\repositories\booking\DiscountRepository;
use booking\services\ContactService;


class BookingCarService
{
    private $bookings;
    private $calendar;
    private $contact;
    private $discounts;

    public function __construct(
        BookingCarRepository $bookings,
        CostCalendarRepository $calendar,
        ContactService $contact,
        DiscountRepository $discounts
    )
    {
        $this->bookings = $bookings;
        $this->calendar = $calendar;
        $this->contact = $contact;
        $this->discounts = $discounts;
    }

    public function create($car_id, $begin_date, $end_date, $count, $delivery, $comment, $promo_code): BookingCar
    {

        $booking = BookingCar::create($car_id, $comment, $begin_date, $end_date, $count, $delivery);
        //$this->bookings->save($booking);
        $days = (int)(($end_date - $begin_date) / (3600 * 24));
        $days_array = [];
        for($i = 0; $i <= $days; $i++) {
            $date = $begin_date + $i * 3600 * 24;
            $calendar = $this->calendar->find($car_id, $date);
            //Проверяем есть ли свободные авто на эту дату
            if ($calendar->getFreeCount() < $count) {
                throw new \DomainException(Lang::t('Недостаточно свободных на дату ') . date('d-m-Y', $date));
            };
            //$days_array[] = BookingCarOnDay::create($calendar->id);
            $booking->addDay($calendar->id);
        }
        //$booking->days = $days_array;
        $discount_id = $this->discounts->find($promo_code, $booking);
        $booking->setDiscount($discount_id);
        if ($booking->discount && $booking->discount->entities == Discount::E_OFFICE_USER) {
            $notUsed = $booking->discount->countNotUsed();
            $_discount = $booking->getAmount() * $booking->discount->percent / 100;
            $bonus = $notUsed < $_discount ? $notUsed : $_discount;
            if ($notUsed <= 0) $bonus = 0;
            $booking->setBonus($bonus);
        }
        if ($booking->car->isConfirmation()) {
            $booking->pay_merchant = 0;
        } else {
            $booking->pay_merchant = \Yii::$app->params['merchant'] * (1 - (int)$booking->car->pay_bank);
        }
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
        return $booking;
    }

    public function remove($id)
    {
        $booking = $this->bookings->get($id);
        $this->bookings->remove($booking->id);
    }

    public function cancel($id)
    {
        $booking = $this->bookings->get($id);
        $booking->cancel();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function cancelPay($id)
    {
        $booking = $this->bookings->get($id);
        $car = $booking->car;
        if ($car->cancellation == null)
            throw new \DomainException(Lang::t('Отмена не предусмотрена'));
        if ($car->cancellation * 3600 * 24 > $booking->begin_at - time())
            throw new \DomainException(Lang::t('Срок отмены истек'));
        if ($booking->begin_at < time())
            throw new \DomainException(Lang::t('Отмена невозможна'));
        $booking->cancelPay();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function confirmation($id)
    {
        $booking = $this->bookings->get($id);
        $booking->payment_provider = 0;
        $booking->confirmation();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function pay($id)
    {
        $booking = $this->bookings->get($id);
        $deduction = \Yii::$app->params['deduction'];
        $payment_provider = $booking->getAmount();
        if ($booking->discount && !$booking->discount->isOffice()) {
            $payment_provider -= $payment_provider * $booking->discount->percent / 100;
        }
        $payment_provider = $payment_provider * (1 - $deduction / 100 - ($booking->pay_merchant == 0 ? \Yii::$app->params['merchant'] : 0) / 100);
        $booking->payment_provider = $payment_provider;
        $booking->pay();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function noticeConfirmation($id, $template = 'pay')
    {
        $booking = $this->bookings->get($id);
        if (!empty($booking->confirmation)) {
            $this->contact->sendNoticeConfirmation($booking, $template);
            return;
        }
        $code = uniqid();
        $booking->confirmation = $code;
        $this->bookings->save($booking);
        $this->contact->sendNoticeConfirmation($booking, $template);
    }

    public function checkConfirmation($id, ConfirmationForm $form): bool
    {
        $booking = $this->bookings->get($id);
        return $booking->confirmation == $form->confirmation;
    }

    private function cancelNotPay($day = 1)
    {
        /** @var BookingCar[] $bookings */
        $bookings = $this->bookings->getNotPay($day);
        foreach ($bookings as $booking) {
            $booking->cancel();
            $this->bookings->save($booking);
        }
    }
}