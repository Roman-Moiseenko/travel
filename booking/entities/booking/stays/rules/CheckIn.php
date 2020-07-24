<?php


namespace booking\entities\booking\stays\rules;


class CheckIn
{
    public $fulltime;
    public $checkin_from;
    public $checkint_to;
    public $checkout_from;
    public $checkout_to;

    public function __construct(
        $fulltime = false,
        $checkin_from = 12, $checkint_to = 24,
        $checkout_from = 0, $checkout_to = 12)
    {
        $this->fulltime = $fulltime;
        $this->checkin_from = $checkin_from;
        $this->checkint_to = $checkint_to;
        $this->checkout_from = $checkout_from;
        $this->checkout_to = $checkout_to;
    }
}