<?php


namespace booking\services\booking\tours;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Cost;
use booking\helpers\BookingHelper;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\repositories\booking\tours\CostCalendarRepository;

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

    public function __construct(BookingTourRepository $bookings, CostCalendarRepository $calendar)
    {
        $this->bookings = $bookings;
        $this->calendar = $calendar;
    }

    public function create($calendar_id, Cost $count): BookingTour
    {
        $calendar = $this->calendar->get($calendar_id);

        $amount = $count->adult * ($calendar->cost->adult ?? 0) +
            $count->child * ($calendar->cost->child ?? 0) +
            $count->preference * ($calendar->cost->preference ?? 0);

        $booking = BookingTour::create($amount, $calendar_id, $count);
        $this->bookings->save($booking);
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
//TODO remove Booking Tour
    }

    public function cancel($id)
    {
        $booking = $this->bookings->get($id);
        $booking->status = BookingHelper::BOOKING_STATUS_CANCEL;
        $this->bookings->save($booking);
    }
}