<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\CostCalendar;
use booking\helpers\CalendarHelper;
use booking\helpers\scr;

class CostCalendarRepository
{
    public function get($id)
    {
        return CostCalendar::findOne($id);
    }

    public function isset($tours_id, $tour_at, $time_at): bool
    {
        $calendar = CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['tour_at' => $tour_at])->andWhere(['time_at' => $time_at])->one();
        return $calendar ? true : false;
    }

    public function getActual($tours_id)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['>', 'tour_at', time()])->all();
    }
    public function getActualForCalendar($tours_id)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['>', 'tour_at', time()])->all();
    }
    public function getDay($tours_id, $date, $notFree = true)
    {
        $costCalendar = CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['tour_at' => $date])->orderBy(['time_at' => SORT_ASC])->all();
        if ($notFree) {
            foreach ($costCalendar as $i => $item) {
                if ($item->free() == 0) unset($costCalendar[$i]);
            }
        }
        return $costCalendar;
    }

    public function getActualInterval($tours_id, $min, $max)
    {
        return CostCalendar::find()
            ->andWhere(['tours_id' => $tours_id])
            ->andWhere(['>=', 'tour_at', $min])
            ->andWhere(['<=', 'tour_at', $max])
            ->all();
    }

    public function getCalendarForDatePicker($tour_id, $month, $year, $day = 1)
    {
        try {
            $interval = CalendarHelper::getInterval($month, $year, $day);
            $calendars = $this->getActualInterval($tour_id, $interval['min'], $interval['max']);
            $result = [];
            foreach ($calendars as $calendar) {
                if ($calendar->free() != 0) {
                    $y = (int)date('Y', $calendar->tour_at);
                    $m = (int)date('m', $calendar->tour_at);
                    $d = (int)date('d', $calendar->tour_at);
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

    public function getCalendarForDatePickerBackend($tour_id)
    {
        try {
            $calendars = CostCalendar::find()
                ->andWhere(['tours_id' => $tour_id])
                ->andWhere(['>', 'tour_at', time()])
                ->all();

            $result = [];
            foreach ($calendars as $calendar) {
                //if ($calendar->getFreeTickets() != 0) {
                    $y = (int)date('Y', $calendar->tour_at);
                    $m = (int)date('m', $calendar->tour_at);
                    $d = (int)date('d', $calendar->tour_at);
                    if (!isset($result[$y][$m][$d])) {
                        $result[$y][$m][$d] = ['count' => 1, 'tickets' => $calendar->tickets];
                    } else {
                        $result[$y][$m][$d]['count']++;
                        $result[$y][$m][$d]['tickets'] += $calendar->tickets;
                    }
               // }
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function getActiveByTour($tour_id): array
    {
        $calendars = CostCalendar::find()
            ->andWhere(['tours_id' => $tour_id])
            //->andWhere(['tour_at' => strtotime('01-12-2020')])
            ->all();
        $result = [];
        foreach ($calendars as $calendar) {

            //scr::p([$calendar->free(), $calendar->tickets]);
            $y = (int)date('Y', $calendar->tour_at);
            $m = (int)date('m', $calendar->tour_at);
            $d = (int)date('d', $calendar->tour_at);
            //echo $y . '/' . $m . '/' . $d . '-' . $calendar->free() . '   ';
            $free = $calendar->free();
            $all = $calendar->tickets;
            if (isset($result[$y]) && isset($result[$y][$m]) && isset($result[$y][$m][$d])) {
                $free += $result[$y][$m][$d]['free'];
                $all += $result[$y][$m][$d]['all'];
            }

            $result[$y][$m][$d] = ['free' => $free, 'count' => ($all - $free), 'all' => $all];
        }
        //exit();
        return $result;
    }
}