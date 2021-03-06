<?php


namespace booking\services\finance;


use booking\entities\booking\BookingItemInterface;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\services\booking\cars\BookingCarService;
use booking\services\booking\funs\BookingFunService;
use booking\services\booking\tours\BookingTourService;

class PayManageService
{
    /**
     * @var BookingTourService
     */
    private $tourService;
    /**
     * @var BookingCarService
     */
    private $carService;
    /**
     * @var BookingFunService
     */
    private $funService;

    public function __construct(BookingTourService $tourService, BookingCarService $carService, BookingFunService $funService)
    {
        $this->tourService = $tourService;
        $this->carService = $carService;
        $this->funService = $funService;
    }

    public function payBooking(BookingItemInterface $booking)
    {
        switch ($booking->getType()) {
            case BookingHelper::BOOKING_TYPE_TOUR:
                $this->tourService->pay($booking->getId());
                break;
            case BookingHelper::BOOKING_TYPE_STAY:
                //TODO Заглушка Stays BookingStayService
                break;
            case BookingHelper::BOOKING_TYPE_CAR:
                $this->carService->pay($booking->getId());
                break;
            case BookingHelper::BOOKING_TYPE_FUNS:
                $this->funService->pay($booking->getId());
                break;
        }
    }
}