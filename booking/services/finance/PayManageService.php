<?php


namespace booking\services\finance;


use booking\entities\booking\BookingItemInterface;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\services\booking\tours\BookingTourService;

class PayManageService
{
    /**
     * @var BookingTourService
     */
    private $tourService;

    public function __construct(BookingTourService $tourService)
    {
        $this->tourService = $tourService;
    }

    public function payBooking(BookingItemInterface $booking)
    {
        switch ($booking->getType()) {
            case BookingHelper::BOOKING_TYPE_TOUR:
                $this->tourService->pay($booking->getId());
                break;
            case BookingHelper::BOOKING_TYPE_STAY:
                //TODO BookingStayService
                break;
            case BookingHelper::BOOKING_TYPE_CAR:
                //TODO BookingCarService
                break;

        }
    }
}