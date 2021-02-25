<?php


namespace booking\entities\booking\stays\rules;


class CheckIn
{
    public $checkin_from;
    public $checkin_to;
    public $checkout_from;
    public $checkout_to;
    public $message;

    public function __construct(
        $checkin_from = null, $checkin_to = null,
        $checkout_from = null, $checkout_to = null,
        $message = false)
    {
        $this->message = $message;

        $this->checkout_from = $checkout_from;
        $this->checkout_to = $checkout_to;
        if ($this->checkout_from >= $this->checkout_to) $this->checkout_from = $this->checkout_to - 1;

        $this->checkin_from = $checkin_from;
        $this->checkin_to = $checkin_to;

        if ($this->checkin_from <= $this->checkout_to) $this->checkin_from += 1;
        if ($this->checkin_from >= $this->checkin_to) $this->checkin_from = $this->checkin_to - 1;
    }
    public static function string_time($time_integer): string
    {
        return str_pad($time_integer, 2, 0, STR_PAD_LEFT) . ':00';
    }
}