<?php


namespace booking\repositories\booking\cars;

use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\CostCalendar;
use booking\entities\Lang;
use booking\helpers\CalendarHelper;

class CostCalendarRepository
{
    public function get($id)
    {
        return CostCalendar::findOne($id);
    }

    public function isset($car_id, $car_at): bool
    {
        $calendar = CostCalendar::find()->andWhere(['car_id' => $car_id])->andWhere(['car_at' => $car_at])->one();
        return $calendar ? true : false;
    }

    public function find($car_id, $car_at)
    {
        return $calendar = CostCalendar::find()->andWhere(['car_id' => $car_id])->andWhere(['car_at' => $car_at])->one();
    }

    public function getActual($car_id)
    {
        return CostCalendar::find()->andWhere(['car_id' => $car_id])->andWhere(['>', 'car_at', time()])->all();
    }

    public function getActualForCalendar($car_id)
    {
        return CostCalendar::find()->andWhere(['car_id' => $car_id])->andWhere(['>', 'car_at', time()])->all();
    }

    public function getDay($car_id, $date)
    {
        return CostCalendar::find()->andWhere(['car_id' => $car_id])->andWhere(['car_at' => $date])->one();
    }

    public function getActualInterval($car_id, $min, $max)
    {
        return CostCalendar::find()
            ->andWhere(['car_id' => $car_id])
            ->andWhere(['>=', 'car_at', $min])
            ->andWhere(['<=', 'car_at', $max])
            ->all();
    }

    public function getCalendarForDatePicker($car_id, $month, $year, $day = 1)
    {
        try {
            $interval = CalendarHelper::getInterval($month, $year, $day);
            $calendars = $this->getActualInterval($car_id, $interval['min'], $interval['max']);
            $result = [];
            foreach ($calendars as $calendar) {
                $y = (int)date('Y', $calendar->car_at);
                $m = (int)date('m', $calendar->car_at);
                $d = (int)date('d', $calendar->car_at);
                $result[$y][$m][$d] = ['count' => $calendar->count, 'cost' => $calendar->cost];
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function getCalendarForDatePickerBackend($car_id)
    {
        try {
            $calendars = CostCalendar::find()
                ->andWhere(['car_id' => $car_id])
                ->andWhere(['>', 'car_at', time()]) //На следующий день
                ->orderBy(['car_at' => SORT_ASC])
                ->all();
            $result = [];
            foreach ($calendars as $calendar) {
                $y = (int)date('Y', $calendar->car_at);
                $m = (int)date('m', $calendar->car_at);
                $d = (int)date('d', $calendar->car_at);
                $result[$y][$m][$d] = ['count' => $calendar->count, 'cost' => $calendar->cost];
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return $result;
    }

    /** *** Для FRONTEND *** */
    public function getCalendarForDatePickerAll($car_id, $date_from = null, $date_to = null)
    {
        //Предварительное заполнение календарей
        if ($date_from == null && $date_to == null) {
            $calendars = CostCalendar::find()
                ->andWhere(['car_id' => $car_id])
                ->andWhere(['>', 'car_at', time()]) //На следующий день
                ->orderBy(['car_at' => SORT_ASC])
                ->all();
            $result = [];
            foreach ($calendars as $calendar) {
                if ($calendar->free() !== 0) {
                    $y = (int)date('Y', $calendar->car_at);
                    $m = (int)date('m', $calendar->car_at);
                    $d = (int)date('d', $calendar->car_at);
                    $result[$y][$m][$d] = true;
                }
            }
            return $result;
        }
        //Выбран 2-й календарь
        if ($date_from == null) {
            $calendars = CostCalendar::find()
                ->andWhere(['car_id' => $car_id])
                ->andWhere(['>=', 'car_at', time() + 3600 * 24]) //На следующий день
                ->andWhere(['<=', 'car_at', $date_to]) //На следующий день
                ->orderBy(['car_at' => SORT_DESC])
                ->all();
            $result = [];
            $pred = $date_to;
            foreach ($calendars as $calendar) {
                if ($calendar->free() !== 0) {
                    if ($pred - $calendar->car_at >= 2 * 3600 * 24) break;
                    $pred = $calendar->car_at;
                    $y = (int)date('Y', $calendar->car_at);
                    $m = (int)date('m', $calendar->car_at);
                    $d = (int)date('d', $calendar->car_at);
                    $result[$y][$m][$d] = true;
                }
            }
            return $result;
        }
        //Выбран 1-й календарь
        if ($date_to == null) {
            $calendars = CostCalendar::find()
                ->andWhere(['car_id' => $car_id])
                ->andWhere(['>=', 'car_at', $date_from]) //На следующий день
                ->orderBy(['car_at' => SORT_ASC])
                ->all();
            $result = [];
            $pred = $date_from;
            foreach ($calendars as $calendar) {
                if ($calendar->free() !== 0) {
                    if ($calendar->car_at - $pred >= 2 * 3600 * 24) break;
                    $pred = $calendar->car_at;
                    $y = (int)date('Y', $calendar->car_at);
                    $m = (int)date('m', $calendar->car_at);
                    $d = (int)date('d', $calendar->car_at);
                    $result[$y][$m][$d] = true;
                }
            }
            return $result;
        }
    }

    public function getRentCar($car_id, $date_from, $date_to)
    {
        $result = [];
        $car = Car::findOne($car_id);
        if ((($date_to - $date_from) / (3600 * 24) + 1) < $car->params->min_rent) {
            $result['error'] = Lang::t('Минимальное бронирование ') . $car->params->min_rent . ' ' . Lang::t('сут');
            //$result['error'] = date('d-m-Y', $date_from) . ' ' . date('d-m-Y', $date_from) . ' ' . (($date_to - $date_from) / (3600 * 24));
        }
        $calendars = CostCalendar::find()
            ->andWhere(['car_id' => $car_id])
            ->andWhere(['>=', 'car_at', $date_from]) //На следующий день
            ->andWhere(['<=', 'car_at', $date_to]) //На следующий день
            ->orderBy(['car_at' => SORT_ASC])
            ->all();
        $max_avto = 999999;
        $amount = 0;
        foreach ($calendars as $calendar) {
            if ($max_avto > $calendar->free()) $max_avto = $calendar->free();
            $amount += $calendar->cost;
        }
        $result['max_avto'] = $max_avto;
        $result['amount'] = $amount;
        $result['delivery'] = !empty($calendar) ? $calendar->car->params->delivery : false;
        return $result;
    }

    public function getActiveByCar($car_id): array
    {
        $calendars = CostCalendar::find()
            ->andWhere(['car_id' => $car_id])
            ->all();
        $result = [];
        foreach ($calendars as $calendar) {
            $y = (int)date('Y', $calendar->car_at);
            $m = (int)date('m', $calendar->car_at);
            $d = (int)date('d', $calendar->car_at);
            $free = $calendar->free();
            $all = $calendar->count;
            $begin = $calendar->isBegin();
            $result[$y][$m][$d] = ['free' => $free, 'count' => ($all - $free), 'begin' => $begin];
        }
        return $result;
    }

}