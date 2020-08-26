<?php


namespace booking\services\booking\tours;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Cost;
use booking\helpers\BookingHelper;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\services\ContactService;


class BookingTourService
{
    /**
     * @var BookingTourRepository
     */
    private $bookings;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;
    /**
     * @var ContactService
     */
    private $contact;

    public function __construct(
        BookingTourRepository $bookings,
        CostCalendarRepository $calendar,
        ContactService $contact)
    {
        $this->bookings = $bookings;
        $this->calendar = $calendar;
        $this->contact = $contact;
    }

    public function create($calendar_id, Cost $count): BookingTour
    {
        $calendar = $this->calendar->get($calendar_id);

        $amount = $count->adult * ($calendar->cost->adult ?? 0) +
            $count->child * ($calendar->cost->child ?? 0) +
            $count->preference * ($calendar->cost->preference ?? 0);

        $booking = BookingTour::create($amount, $calendar_id, $count);
        $this->bookings->save($booking);
        $this->contact->sendNoticeBooking($booking);
        return $booking;
    }

    public function edit($booking_id, Cost $count)
    {
        $booking = $this->bookings->get($booking_id);
        $calendar = $booking->calendar;
        $amount = $count->adult * ($calendar->cost->adult ?? 0) +
            $count->child * ($calendar->cost->child ?? 0) +
            $count->preference * ($calendar->cost->preference ?? 0);

        $booking->edit($amount, $count);
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
        $booking->cancelPay();
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
}