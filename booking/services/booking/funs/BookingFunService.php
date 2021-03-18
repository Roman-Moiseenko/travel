<?php


namespace booking\services\booking\funs;


use booking\entities\booking\Discount;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\repositories\booking\DiscountRepository;

use booking\repositories\booking\funs\BookingFunRepository;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\services\booking\BookingService;
use booking\services\ContactService;


class BookingFunService extends BookingService
{
    private $bookings;
    private $calendar;
    private $contact;
    private $discounts;

    public function __construct(
        BookingFunRepository $bookings,
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

    public function create(array $calendar_ids, Cost $count, $comment): BookingFun
    {
        $booking = BookingFun::create($calendar_ids, $count, $comment);

        foreach ($booking->days as $day)
            if ($day->calendar->free() < $count->count()) {
                throw new \DomainException(Lang::t('Упс! Места закончились'));
            }
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
        $fun = $booking->fun;
        if ($fun->cancellation == null)
            throw new \DomainException(Lang::t('Отмена не предусмотрена'));
        if ($fun->cancellation * 3600 * 24 > $booking->getDate() - time())
            throw new \DomainException(Lang::t('Срок отмены истек'));
        if ($booking->getDate() < time())
            throw new \DomainException(Lang::t('Мероприятие завершено'));
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
        /** @var BookingFun[] $bookings */
        $bookings = $this->bookings->getNotPay($day);
        foreach ($bookings as $booking) {
            $booking->cancel();
            $this->bookings->save($booking);
        }
    }
}