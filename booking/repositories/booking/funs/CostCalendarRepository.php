<?php


namespace booking\repositories\booking\funs;

use booking\entities\booking\funs\CostCalendar;
use booking\helpers\CalendarHelper;

class CostCalendarRepository
{
    public function get($id)
    {
        return CostCalendar::findOne($id);
    }

    public function isset($fun_id, $fun_at, $time_at): bool
    {
        $calendar = CostCalendar::find()->andWhere(['fun_id' => $fun_id])->andWhere(['fun_at' => $fun_at])->andWhere(['time_at' => $time_at])->one();
        return $calendar ? true : false;
    }

    public function getActual($fun_id)
    {
        return CostCalendar::find()->andWhere(['fun_id' => $fun_id])->andWhere(['>', 'fun_at', time()])->all();
    }

    public function getActualForCalendar($fun_id)
    {
        return CostCalendar::find()->andWhere(['fun_id' => $fun_id])->andWhere(['>', 'fun_at', time()])->all();
    }

    public function getDay($fun_id, $date, $notFree = true)
    {
        $costCalendar = CostCalendar::find()->andWhere(['fun_id' => $fun_id])->andWhere(['fun_at' => $date])->orderBy(['time_at' => SORT_ASC])->all();
        if ($notFree) {
            foreach ($costCalendar as $i => $item) {
                if ($item->free() == 0) unset($costCalendar[$i]);
            }
        }
        return $costCalendar;
    }

    public function getActualInterval($fun_id, $min, $max)
    {
        return CostCalendar::find()
            ->andWhere(['fun_id' => $fun_id])
            ->andWhere(['>=', 'fun_at', $min])
            ->andWhere(['<=', 'fun_at', $max])
            ->all();
    }

    public function getCalendarForDatePicker($fun_id, $month, $year, $day = 1)
    {
        try {
            $interval = CalendarHelper::getInterval($month, $year, $day);
            $calendars = $this->getActualInterval($fun_id, $interval['min'], $interval['max']);
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

    public function getCalendarForDatePickerBackend($fun_id)
    {
        try {
            $calendars = CostCalendar::find()
                ->andWhere(['fun_id' => $fun_id])
                ->andWhere(['>', 'fun_at', time()])
                ->all();
            $result = [];
            foreach ($calendars as $calendar) {
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
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function getActiveByFun($fun_id): array
    {
        $calendars = CostCalendar::find()
            ->andWhere(['fun_id' => $fun_id])
            ->all();
        $result = [];
        foreach ($calendars as $calendar) {
            $y = (int)date('Y', $calendar->fun_at);
            $m = (int)date('m', $calendar->fun_at);
            $d = (int)date('d', $calendar->fun_at);
            $free = $calendar->free();
            $all = $calendar->tickets;
            if (isset($result[$y]) && isset($result[$y][$m]) && isset($result[$y][$m][$d])) {
                $free += $result[$y][$m][$d]['free'];
                $all += $result[$y][$m][$d]['all'];
            }

            $result[$y][$m][$d] = ['free' => $free, 'count' => ($all - $free), 'all' => $all];
        }
        return $result;
    }

    /** *** Для FRONTEND *** */
    public function getCalendarForDatePickerAll($fun_id)
    {
        //Предварительное заполнение календарей
        $calendars = CostCalendar::find()
            ->andWhere(['fun_id' => $fun_id])
            ->andWhere(['>', 'fun_at', time()]) //На следующий день
            ->groupBy(['fun_at'])
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

    public function getCurrentForClearTime($fun_id, int $fun_at)
    {
        $calendar = CostCalendar::find()->andWhere(['fun_id' => $fun_id])->andWhere(['fun_at' => $fun_at])->one();
        return $calendar;
    }

    public function getTimes($fun_id, int $fun_at, $view_free = false)
    {
        $calendar = CostCalendar::find()->andWhere(['fun_id' => $fun_id])->andWhere(['fun_at' => $fun_at])->orderBy(['time_at' => SORT_ASC])->all();
        foreach ($calendar as $i => $item) {
            if ($item->free() == 0 and $view_free == false) unset($calendar[$i]);
        }
        return $calendar;
    }
}