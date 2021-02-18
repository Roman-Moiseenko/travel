<?php


namespace booking\entities\booking\stays\rules;


class CheckIn
{
    const CHECK_IN = 14;
    const CHECK_OUT = 12;
    public $fulltime;
    public $checkin_from;
    public $checkin_to;
    public $checkout_from;
    public $checkout_to;

    public function __construct(
        $fulltime = false,
        $checkin_from = 14, $checkin_to = 24,
        $checkout_from = 0, $checkout_to = 12)
    {
        $this->fulltime = $fulltime;

        $this->checkout_from = $checkout_from;
        $this->checkout_to = $checkout_to > self::CHECK_OUT ? self::CHECK_OUT : $checkout_to;

        $this->checkin_from = $checkin_from < self::CHECK_IN ? self::CHECK_IN : $checkin_from;
        $this->checkin_to = $checkin_to;
    }
}