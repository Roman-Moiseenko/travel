<?php


namespace booking\services\check;

use booking\entities\booking\BaseBooking;
use booking\helpers\BookingHelper;
use booking\repositories\check\UserRepository;

class GiveOutService
{

    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function giveOut($user_id, $type, $booking_id)
    {
        $_class = BookingHelper::LIST_BOOKING_TYPE[$type];
        /** @var BaseBooking $booking */
        $booking = $_class::findOne($booking_id);
        //TODO Переделать в интерфейс->giveOut($user->id)
        $booking->give_out = true;
        $booking->give_at = time();
        $booking->give_user_id = $user_id;
        $booking->save();
    }
}