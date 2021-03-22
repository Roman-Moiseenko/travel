<?php


namespace booking\services\finance;


use booking\entities\booking\BaseBooking;
use booking\helpers\BookingHelper;
use booking\services\booking\cars\BookingCarService;
use booking\services\booking\funs\BookingFunService;
use booking\services\booking\stays\BookingStayService;
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
    /**
     * @var BookingStayService
     */
    private $stayService;

    public function __construct(
        BookingTourService $tourService,
        BookingCarService $carService,
        BookingFunService $funService,
        BookingStayService $stayService
    )
    {
        $this->tourService = $tourService;
        $this->carService = $carService;
        $this->funService = $funService;
        $this->stayService = $stayService;
    }

    public function payBooking(BaseBooking $booking)
    {
        //TODO ** BOOKING_OBJECT **
        switch ($booking->getType()) {
            case BookingHelper::BOOKING_TYPE_TOUR:
                $this->tourService->pay($booking->getId());
                break;
            case BookingHelper::BOOKING_TYPE_STAY:
                $this->stayService->pay($booking->getId());
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