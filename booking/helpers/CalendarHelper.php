<?php


namespace booking\helpers;


class CalendarHelper
{
    public static function array4Month(): array
    {
        $month = date('m', time());
        $year  = date('Y', time());
        $j = 0;
        $data = [];
        for ($i = 1; $i < 5; $i++) {
            $data[$i]['start'] = '01-' . ($month + $i - 1 - $j) . '-' . $year;
            if ($month + $i == 13) {
                $month = 1;
                $year++;
                $j = $i;
            }
            $data[$i]['end'] = date('d-m-Y', strtotime('01-' . ($month + $i - $j) . '-' . $year) - 24 * 3600);
        }
        return $data;
    }
    public static function getInterval($month, $year): array
    {
        $result['min'] = strtotime('01-' . $month . '-' . $year . ' 00:00:00');
        if ($month == 12) {
            $result['max'] = strtotime('31-12-' . $year . ' 00:00:00');
        } else {
            $result['max'] = strtotime('01-' . ($month + 1) . '-' . $year . ' 00:00:00') - 24 * 3600 ;
        }
        return  $result;
    }
}