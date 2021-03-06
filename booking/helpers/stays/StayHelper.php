<?php


namespace booking\helpers\stays;


use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\stays\CostCalendar;
use booking\entities\booking\stays\ReviewStay;
use booking\entities\booking\stays\Stay;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\helpers\SysHelper;

class StayHelper
{

    /*
        public static function ageLimit(AgeLimit $ageLimit): string
        {
            if ($ageLimit->on == null) return Lang::t('Не задано');
            if ($ageLimit->on == false) return Lang::t('нет');
            if ($ageLimit->on == true) {
                $min = empty($ageLimit->ageMin) ? '' : Lang::t('с') . ' ' . $ageLimit->ageMin . ' ' . Lang::t('лет');
                $max = empty($ageLimit->ageMax) ? '' : ' ' . Lang::t('до') . ' ' . $ageLimit->ageMax . ' ' . Lang::t('лет');
                return $min . $max;
            }
        }*/

    public static function listExtra(): array
    {
        // return Extra::find()->andWhere(['user_id' => \Yii::$app->user->id])->all();
    }


    public static function getCountActiveBooking($tour_id): int
    {
        //TODO заглушка
        /*
        $bookings = BookingStay::find()->andWhere(['IN', 'status', [
            BookingHelper::BOOKING_STATUS_NEW,
            BookingHelper::BOOKING_STATUS_PAY,
            BookingHelper::BOOKING_STATUS_CONFIRMATION,

        ]
        ])
            ->andWhere(
                [
                    'IN',
                    'calendar_id',
                    CostCalendar::find()->select('id')->andWhere(['tours_id' => $tour_id])->andWhere(['>=', 'tour_at', time()])
                ]
            )
            ->all();
        $count = 0;
        foreach ($bookings as $booking) {
            $count += $booking->countTickets();
        }
        return $count;*/
        return 0;
    }

    public static function getCountReview($tour_id): int
    {
        //TODO заглушка
        //return ReviewStay::find()->andWhere(['tour_id' => $tour_id])->count();
        return 0;
    }

    public static function listChildAge($max = 16): array
    {
        $result = [];
        $result[] = 'С любого';
        for ($i = 1; $i <= $max; $i++) {
            $result[] = $i;
        }
        return $result;
    }

    public static function listAge($max = 16): array
    {
        $result = [];
        for ($i = 0; $i <= $max; $i++) {
            $str = ($i == 0 || $i > 4) ? 'лет' : ($i == 1 ? 'год' : 'года');
            $result[] = $i . ' ' . $str;
        }
        return $result;
    }

    public static function listNumber($min = 0, $max = 16): array
    {
        $result = [];
        for ($i = $min; $i <= $max; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

    public static function listTime($min = 0, $max = 24): array
    {
        $result = [];
        for ($i = $min; $i <= $max; $i++) {
            $result[$i] = str_pad($i, 2, 0, STR_PAD_LEFT) . ':00';
        }
        return $result;
    }

    public static function listGuest()
    {
        $result[1] = '1 взрослый';
        for ($i = 2; $i <= 20; $i++) {
            $result[$i] = $i . ' взрослых';
        }
        return $result;
    }

    public static function listChildren()
    {
        $result[0] = 'Без детей';
        $result[1] = '1 ребенок';
        for ($i = 2; $i <= 10; $i++) {
            $result[$i] = $i . ' детей';
        }
        return $result;
    }

    public static function getCostByParams(Stay $stay, array $params)
    {
        if (empty($params)) return $stay->cost_base;
        $guest = (int)$params['guest'];
        $children = (int)$params['children'];
        $children_age = $params['children_age'];
        if ($children > 0) {
            $n = $children;
            for($i = 1; $i <= $n; $i ++) {
                if ($children_age[$i] >= $stay->rules->beds->child_by_adult) {$guest++; $children--;}
            }

            if ($children > round($guest / 2))  {
                $guest += round(($children - round($guest / 2)) / 2);
            }
        }
        if (empty($params['date_from'])) {
            $add_guest = ($guest > $stay->guest_base) ? ($guest - $stay->guest_base) : 0;
            return $stay->cost_base + $add_guest * $stay->cost_add;
        }

        $begin = SysHelper::_renderDate($params['date_from']);
        $end = SysHelper::_renderDate($params['date_to']);
        $cost = 0;
        $calendars = CostCalendar::find()->andWhere(['stay_id' => $stay->id])->andWhere(['>=', 'stay_at', $begin])->andWhere(['<=', 'stay_at', $end - 24 * 60 * 60])->orderBy('stay_at')->all();
        foreach ($calendars as $calendar) {
            $add_guest = ($guest > $calendar->guest_base) ? ($guest - $calendar->guest_base) : 0;
            $cost += $calendar->cost_base + $add_guest * $calendar->cost_add;
        }

        return $cost;
    }

    public static function textRooms(Stay $stay)
    {
        $count = count($stay->bedrooms);
        switch ($count) {
            case 1: $text = Lang::t('спальня');
            break;
            case 2:
            case 3:
            case 4: $text = Lang::t('спальни');
            break;
            default: $text = Lang::t('спален');
        }
        return $count . ' ' . $text;
    }

    public static function textBeds(Stay $stay, $one = true)
    {
        $count = 0;
        foreach ($stay->bedrooms as $room) {
            foreach ($room->assignBeds as $assignBed)
            $count += $assignBed->count;
        }
        if ($one) {
        switch ($count) {
            case 1: $text = Lang::t('кровать');
                break;
            case 2:
            case 3:
            case 4: $text = Lang::t('кровати');
                break;
            default: $text = Lang::t('кроватей');
        }
        } else {
            if ($count == 1) {$text = Lang::t('кроватью');} else {$text = Lang::t('кроватьями');}
        }

        return $count . ' ' . $text;
    }

    public static function textKitchen($count_kitchen)
    {
        switch ($count_kitchen) {
            case 1: $text = Lang::t('кухня');
                break;
            case 2:
            case 3:
            case 4: $text = Lang::t('кухни');
                break;
            default: $text = Lang::t('кухонь');
        }
        return $count_kitchen . ' ' . $text;
    }

    public static function textBath($count_bath)
    {
        switch ($count_bath) {
            case 1: $text = Lang::t('ванная комната');
                break;
            default: $text = Lang::t('ванных комнат');
        }
        return $count_bath . ' ' . $text;
    }
}