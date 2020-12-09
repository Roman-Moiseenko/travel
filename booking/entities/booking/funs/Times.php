<?php


namespace booking\entities\booking\funs;


class Times
{
    public $begin;
    public $end;

    public function __construct($begin = null, $end = null)
    {
        $this->begin = $begin;
        $this->end = $end;
    }
}