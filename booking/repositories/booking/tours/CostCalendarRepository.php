<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\CostCalendar;
use booking\helpers\CalendarHelper;

class CostCalendarRepository
{
    public function get($id)
    {
        return CostCalendar::findOne($id);
    }

    public function isset($tour_at, $time_at): bool
    {
        $calendar = CostCalendar::find()->andWhere(['tour_at' => $tour_at])->andWhere(['time_at' => $time_at])->one();
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
    public function getDay($tours_id, $date)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['tour_at' => $date])->orderBy(['time_at' => SORT_ASC])->all();
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
                $y = (int)date('Y', $calendar->tour_at);
                $m = (int)date('m', $calendar->tour_at);
                $d = (int)date('d', $calendar->tour_at);
                if (!isset($result[$y][$m][$d])) {
                    $result[$y][$m][$d] = ['count' => 1];
                } else {
                    $result[$y][$m][$d]['count']++;
                }
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }
}