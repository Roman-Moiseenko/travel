<?php


namespace frontend\widgets\cabinet;


use booking\entities\booking\BaseObjectOfBooking;
use booking\entities\user\User;
use yii\base\Widget;

class CheckBookingWidget extends Widget
{
    /** @var $booking BaseObjectOfBooking */
    public $booking;
    /* @var $user User */
    public $user;
    /* @var $action string */
    public $action;

    public function run()
    {
        return $this->render('check-booking', [
            'booking' => $this->booking,
            'user' => $this->user,
            'action' => $this->action,
        ]);
    }
}