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
use booking\services\booking\BookingService;
use booking\services\ContactService;


class BookingCarService extends BookingService
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

    public function create($car_id, $begin_date, $end_date, $count, $delivery, $comment): BookingCar
    {
        $booking = BookingCar::create($car_id, $comment, $begin_date, $end_date, $count, $delivery);
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
        $booking->confirmation();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function pay($id)
    {
        $booking = $this->bookings->get($id);
        $booking->pay();
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
    }

    public function noticeConfirmation($id, $template = 'pay')
    {
        $booking = $this->bookings->get($id);
        if (!empty($booking->getConfirmationCode())) {
            $this->contact->sendNoticeConfirmation($booking, $template);
            return;
        }
        $code = uniqid();
        $booking->setConfirmation($code);
        $this->bookings->save($booking);
        $this->contact->sendNoticeConfirmation($booking, $template);
    }

    public function checkConfirmation($id, ConfirmationForm $form): bool
    {
        $booking = $this->bookings->get($id);
        return $booking->getConfirmationCode() == $form->confirmation;
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