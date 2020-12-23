<?php


namespace admin\widgest\calendar;


use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\Times;
use yii\base\Widget;

class SetTimesWidget extends Widget
{

    public $fun;
    public $calendars;
    public $errors;
    public $D;
    public $M;
    public $Y;
    public $clear;

    private function getDayFunsPeriod(Fun $fun, array $times, array $calendars)
    {
        $day_funs = [];
        //return $times;
        if (count($calendars) !== 0) { // из календаря,
            foreach ($calendars as $i => $calendar) {
                $day_funs[$i]['check'] = true;
                $day_funs[$i]['begin'] = substr($calendar->time_at, 0, 5);
                $day_funs[$i]['end'] = substr($calendar->time_at, 8, 5);
                $day_funs[$i]['quantity'] = $calendar->tickets;
                $day_funs[$i]['cost_adult'] = $calendar->cost->adult;
                $day_funs[$i]['cost_child'] = $calendar->cost->child;
                $day_funs[$i]['cost_preference'] = $calendar->cost->preference;
            }

        } else {
            foreach ($times as $i => $time) { //базовые данные
                $day_funs[$i]['check'] = false;
                $day_funs[$i]['begin'] = $time->begin;
                $day_funs[$i]['end'] = $time->end;
                $day_funs[$i]['quantity'] = $fun->quantity;
                $day_funs[$i]['cost_adult'] = $fun->baseCost->adult;
                $day_funs[$i]['cost_child'] = $fun->baseCost->child;
                $day_funs[$i]['cost_preference'] = $fun->baseCost->preference;
            }
        }
        return $day_funs;
    }

    public function run()
    {
        $prefix = '';
        $day_funs = [];
        if (Fun::isClearTimes($this->fun->type_time)) {
            $prefix = '_clear';
            $day_funs = $this->getDayFunsPeriod($this->fun, [new Times(null, null)], $this->calendars);
        }
        if ($this->fun->type_time == Fun::TYPE_TIME_INTERVAL) {
            $prefix = '_interval';
            // формируем массив с интервалом,
            $times = Fun::getTimesByInterval($this->fun->times[0]->begin, $this->fun->times[0]->end, $this->fun->times[1]->begin);
            // сверяем с календарем, и заполняем новый массив
            $day_funs = $this->getDayFunsPeriod($this->fun, $times, $this->calendars);
        }

        if ($this->fun->type_time == Fun::TYPE_TIME_EXACT || $this->fun->type_time == Fun::TYPE_TIME_EXACT_FULL) {
            $prefix = '_exact';
            $day_funs = $this->getDayFunsPeriod($this->fun, $this->fun->times, $this->calendars);
        }

        return $this->render('_set_times' . $prefix, [
            'D' => $this->D, 'M' => $this->M, 'Y' => $this->Y,
            'day_funs' => $day_funs,
            'errors' => $this->errors,
            'quantity' => $this->fun->quantity,
            'clear' => $this->clear,
        ]);
    }
}