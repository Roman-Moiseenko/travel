<?php


namespace booking\entities\booking\funs;


class WorkMode
{
    public $day_begin;
    public $day_end;
    public $break_begin;
    public $break_end;

    public function __construct($day_begin = null, $day_end = null, $break_begin = null, $break_end = null)
    {
        $this->day_begin = $day_begin;
        $this->day_end = $day_end;
        $this->break_begin = $break_begin;
        $this->break_end = $break_end;
    }
}