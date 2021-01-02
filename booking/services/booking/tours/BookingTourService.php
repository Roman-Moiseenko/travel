<?php


namespace booking\services\booking\tours;


use booking\entities\booking\Discount;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\helpers\BookingHelper;
use booking\repositories\booking\DiscountRepository;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\services\booking\DiscountService;
use booking\services\ContactService;


class BookingTourService
{
    private $bookings;
    private $calendar;
    private $contact;
    private $discounts;

    public function __construct(
        BookingTourRepository $bookings,
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

    public function create($calendar_id, Cost $count, $promo_code): BookingTour
    {
        $booking = BookingTour::create($calendar_id, $count);
        if ($booking->calendar->free() < $count->count()) {
            throw new \DomainException(Lang::t('Упс! Места закончились'));
        }

        $discount_id = $this->discounts->find($promo_code, $booking);
        $booking->setDiscount($discount_id);

        if ($booking->discount && $booking->discount->entities == Discount::E_OFFICE_USER) {
            $notUsed = $booking->discount->countNotUsed();
            $_discount = $booking->getAmount() * $booking->discount->percent / 100;
            $bonus = $notUsed < $_discount ? $notUsed : $_discount;
            if ($notUsed <= 0) $bonus = 0;
            $booking->setBonus($bonus);
        }

        $booking->pay_merchant = 0;

        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
        return $booking;
    }

    public function edit($booking_id, Cost $count)
    {
        $booking = $this->bookings->get($booking_id);
        $booking->edit($count);
        $this->bookings->save($booking);
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
        $tour = $booking->calendar->tour;
        if ($tour->cancellation == null)
            throw new \DomainException(Lang::t('Отмена не предусмотрена'));
        if ($tour->cancellation * 3600 * 24 > $booking->calendar->tour_at - time())
            throw new \DomainException(Lang::t('Срок отмены истек'));
        if ($booking->calendar->tour_at < time())
            throw new \DomainException(Lang::t('Тур завершен'));
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
        $merchant = \Yii::$app->params['merchant'];
        $payment_provider = $booking->getAmount();
        if ($booking->discount && !$booking->discount->isOffice()) {
            $payment_provider -= $payment_provider * $booking->discount->percent / 100;
        }
        $payment_provider = $payment_provider * (1 - $deduction / 100 - $merchant / 100);
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
        /** @var BookingTour[] $bookings */
        $bookings = $this->bookings->getNotPay($day);
        foreach ($bookings as $booking) {
            $booking->cancel();
            $this->bookings->save($booking);
        }
    }
}