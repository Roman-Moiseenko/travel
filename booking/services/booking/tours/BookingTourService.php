<?php


namespace booking\services\booking\tours;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Cost;
use booking\entities\booking\tours\services\BookingServices;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\services\booking\BookingService;
use booking\services\ContactService;
use booking\services\finance\RefundService;


class BookingTourService extends BookingService
{
    private $bookings;
    private $calendar;
    private $contact;
    /**
     * @var RefundService
     */
    private $refund;
    /**
     * @var StackService
     */
    private $stackService;

    public function __construct(
        BookingTourRepository $bookings,
        CostCalendarRepository $calendar,
        ContactService $contact,
        RefundService $refund,
        StackService $stackService
    )
    {
        $this->bookings = $bookings;
        $this->calendar = $calendar;
        $this->contact = $contact;
        $this->refund = $refund;
        $this->stackService = $stackService;
    }

    public function create($calendar_id, Cost $count, $time_count, $capacity_id, $transfer_id): BookingTour
    {
        $calendar = $this->calendar->get($calendar_id);
        if ($time_count || $capacity_id || $transfer_id) {
            $tour = $calendar->tour;
            if ($capacity_id) {
                $capacity = $tour->Capacity($capacity_id);
                $capacity_count = $capacity->count;
                $capacity_percent = $capacity->percent;
            } else {
                $capacity_count = null;
                $capacity_percent = null;
            }
            if ($transfer_id) {
                $transfer = $tour->Transfer($transfer_id);
                $transfer_path = $transfer->from->getName() . '-' . $transfer->to->getName();
                $transfer_cost = $transfer->cost;
            } else {
                $transfer_path = null;
                $transfer_cost = null;
            }
            $services = new BookingServices(
                $tour->extra_time_cost,
                $time_count,
                $capacity_count,
                $capacity_percent,
                $transfer_path,
                $transfer_cost
            );
        } else {
            $services = null;
        }

        $booking = BookingTour::create($calendar, $count, $services);

        if ($booking->calendar->free() < $count->count() ||  //кол-во свободных меньше покупаемого
            !$this->stackService->_empty($booking->calendar->tours_id, $booking->calendar->tour_at)) {  //Стек не пуст
            throw new \DomainException(Lang::t('Упс! Места закончились'));
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
        /** @var BookingTour[] $bookings */
        $bookings = $this->bookings->getNotPay($day);
        foreach ($bookings as $booking) {
            $booking->cancel();
            $this->bookings->save($booking);
        }
    }

    public function cancelProvider($calendar_id)
    {
        $bookings = $this->bookings->getByCalendar($calendar_id);
        foreach ($bookings as $booking) {
            if ($booking->isPay()) { // если был оплачен, отмена с возвратом
                $this->refund->create($booking); //сформировать на возврат оплаты
                $booking->cancelPay(); // отменить оплату
            } else {
                $booking->cancel(); // если не оплачен, просто отмена
            }
            $this->bookings->save($booking);
            $this->contact->sendNoticeBooking($booking); // отправить письмо

        }
    }
}