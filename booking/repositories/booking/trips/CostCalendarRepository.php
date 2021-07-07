<?php


namespace booking\repositories\booking\trips;

use booking\entities\booking\trips\CostCalendar;
use booking\helpers\CalendarHelper;


class CostCalendarRepository
{


    public function get($id)
    {
        return CostCalendar::findOne($id);
    }

    public function isset($trip_id, $trip_at): bool
    {
        $calendar = CostCalendar::find()->andWhere(['trip_id' => $trip_id])->andWhere(['trip_at' => $trip_at])->one();
        return $calendar ? true : false;
    }

    public function getActual($trip_id)
    {
        return CostCalendar::find()->andWhere(['trip_id' => $trip_id])->andWhere(['>', 'trip_at', time()])->all();
    }

    public function getActualForCalendar($trip_id)
    {
        return CostCalendar::find()->andWhere(['trip_id' => $trip_id])->andWhere(['>', 'trip_at', time()])->all();
    }

    public function getDay($trip_id, $date)
    {
        $costCalendar = CostCalendar::find()->andWhere(['trip_id' => $trip_id])->andWhere(['trip_at' => $date])->one();
        /*if ($notFree) {
            foreach ($costCalendar as $i => $item) {
                if ($item->free() == 0) unset($costCalendar[$i]);
            }
        }*/
        return $costCalendar;
    }

    public function getActualInterval($trip_id, $min, $max)
    {
        return CostCalendar::find()
            ->andWhere(['trip_id' => $trip_id])
            ->andWhere(['>=', 'trip_at', $min])
            ->andWhere(['<=', 'trip_at', $max])
            ->all();
    }

    public function getCalendarForDatePicker($trip_id, $month, $year, $day = 1)
    {
        //TODO Ускорить работу через SQL запросы
        try {
            $interval = CalendarHelper::getInterval($month, $year, $day);
            $calendars = $this->getActualInterval($trip_id, $interval['min'], $interval['max']);
            $result = [];
            foreach ($calendars as $calendar) {

                    $y = (int)date('Y', $calendar->trip_at);
                    $m = (int)date('m', $calendar->trip_at);
                    $d = (int)date('d', $calendar->trip_at);
                    if (!isset($result[$y][$m][$d])) {
                        $result[$y][$m][$d] = true;

                }
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function getCalendarForDatePickerBackend($trip_id)
    {
        try {
            $calendars = CostCalendar::find()
                ->andWhere(['trip_id' => $trip_id])
                ->andWhere(['>', 'trip_at', time()])
                ->all();

            $result = [];
            foreach ($calendars as $calendar) {
                $y = (int)date('Y', $calendar->trip_at);
                $m = (int)date('m', $calendar->trip_at);
                $d = (int)date('d', $calendar->trip_at);
                if (!isset($result[$y][$m][$d])) {
                    $result[$y][$m][$d] = ['count' => 1, 'quantity' => $calendar->quantity];
                } else {
                    $result[$y][$m][$d]['count']++;
                    $result[$y][$m][$d]['quantity'] += $calendar->quantity;
                }
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function getActiveByTrip($trip_id): array
    {
        $calendars = CostCalendar::find()
            ->andWhere(['trip_id' => $trip_id])
            ->all();
        $result = [];
        foreach ($calendars as $calendar) {
            $y = (int)date('Y', $calendar->trip_at);
            $m = (int)date('m', $calendar->trip_at);
            $d = (int)date('d', $calendar->trip_at);
            //echo $y . '/' . $m . '/' . $d . '-' . $calendar->free() . '   ';
            $free = $calendar->free();
            $all = $calendar->quantity;
            if (isset($result[$y]) && isset($result[$y][$m]) && isset($result[$y][$m][$d])) {
                $free += $result[$y][$m][$d]['free'];
                $all += $result[$y][$m][$d]['all'];
            }

            $result[$y][$m][$d] = ['free' => $free, 'count' => ($all - $free), 'all' => $all];
        }
        return $result;
    }
}