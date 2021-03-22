<?php


namespace booking\repositories\booking\stays;

use booking\entities\booking\stays\CostCalendar;
use booking\helpers\CalendarHelper;

class CostCalendarRepository
{
    public function get($id)
    {
        return CostCalendar::findOne($id);
    }

    public function isset($stay_id, $stay_at): bool
    {
        $calendar = CostCalendar::find()->andWhere(['stay_id' => $stay_id])->andWhere(['stay_at' => $stay_at])->one();
        return $calendar ? true : false;
    }

    public function getActual($stay_id)
    {
        return CostCalendar::find()->andWhere(['stay_id' => $stay_id])->andWhere(['>', 'stay_at', time()])->all();
    }

    public function getActualForCalendar($stay_id)
    {
        return CostCalendar::find()->andWhere(['stay_id' => $stay_id])->andWhere(['>', 'stay_at', time()])->all();
    }

    public function getDay($stay_id, $date, $notFree = true): ?CostCalendar
    {
        $costCalendar = CostCalendar::find()->andWhere(['stay_id' => $stay_id])->andWhere(['stay_at' => $date])->one();
        if ($notFree && $costCalendar->free() == 0) {
            return null;
        }
        return $costCalendar;
    }

    public function getActualInterval($stay_id, $min, $max)
    {
        return CostCalendar::find()
            ->andWhere(['stay_id' => $stay_id])
            ->andWhere(['>=', 'stay_at', $min])
            ->andWhere(['<=', 'stay_at', $max])
            ->all();
    }

    public function getCalendarForDatePicker($stay_id, $month, $year, $day = 1)
    {
        //TODO !!!!!!!!!!!!!!!!
        try {
            $interval = CalendarHelper::getInterval($month, $year, $day);
            $calendars = $this->getActualInterval($stay_id, $interval['min'], $interval['max']);
            $result = [];
            foreach ($calendars as $calendar) {
                if ($calendar->free() != 0) {
                    $y = (int)date('Y', $calendar->fun_at);
                    $m = (int)date('m', $calendar->fun_at);
                    $d = (int)date('d', $calendar->fun_at);
                    if (!isset($result[$y][$m][$d])) {
                        $result[$y][$m][$d] = ['count' => 1, 'tickets' => $calendar->tickets];
                    } else {
                        $result[$y][$m][$d]['count']++;
                        $result[$y][$m][$d]['tickets'] += $calendar->tickets;
                    }
                }
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function getCalendarForDatePickerBackend($stay_id)
    {
        try {
            $calendars = CostCalendar::find()
                ->andWhere(['stay_id' => $stay_id])
                ->andWhere(['>', 'stay_at', time()])
                ->all();
            $result = [];
            foreach ($calendars as $calendar) {
                $y = (int)date('Y', $calendar->stay_at);
                $m = (int)date('m', $calendar->stay_at);
                $d = (int)date('d', $calendar->stay_at);
                $result[$y][$m][$d] = ['cost_base' => $calendar->cost_base, 'cost_add' => $calendar->cost_add];
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function getActiveByStay($stay_id): array
    {
        $calendars = CostCalendar::find()
            ->andWhere(['stay_id' => $stay_id])
            ->all();
        $result = [];
        foreach ($calendars as $calendar) {
            $y = (int)date('Y', $calendar->stay_at);
            $m = (int)date('m', $calendar->stay_at);
            $d = (int)date('d', $calendar->stay_at);
            $free = $calendar->free();
            $begin = $calendar->isBegin();
            $result[$y][$m][$d] = ['free' => $free,  'begin' => $begin];
        }
        return $result;
    }

    /** *** Для FRONTEND *** */
    public function getCalendarForDatePickerAll($stay_id)
    {
        //Предварительное заполнение календарей
        $calendars = CostCalendar::find()
            ->andWhere(['stay_id' => $stay_id])
            ->andWhere(['>', 'stay_at', time()]) //На следующий день
            ->all();
        $result = [];
        foreach ($calendars as $calendar) {
            if ($calendar->free() !== 0) {
                $y = (int)date('Y', $calendar->fun_at);
                $m = (int)date('m', $calendar->fun_at);
                $d = (int)date('d', $calendar->fun_at);
                $result[$y][$m][$d] = true;
            }
        }
        return $result;
    }

    public function getCurrentForClearTime($stay_id, int $stay_at)
    {
        $calendar = CostCalendar::find()->andWhere(['stay_id' => $stay_id])->andWhere(['stay_at' => $stay_at])->one();
        return $calendar;
    }
}