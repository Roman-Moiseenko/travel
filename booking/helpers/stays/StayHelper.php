<?php


namespace booking\helpers\stays;


use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\stays\CostCalendar;
use booking\entities\booking\stays\ReviewStay;
use booking\entities\booking\stays\Stay;
use booking\entities\Lang;
use booking\helpers\BookingHelper;

class StayHelper
{
    public static function getCountActiveBooking($stay_id): int
    {

        $bookings = BookingStay::find()->andWhere(['IN', 'status', [
            BookingHelper::BOOKING_STATUS_NEW,
            BookingHelper::BOOKING_STATUS_PAY,
            BookingHelper::BOOKING_STATUS_CONFIRMATION,
        ]
        ])
            ->andWhere(['object_id' => $stay_id])
            ->andWhere(['>=', 'begin_at', time()])
            ->all();
        $count = 0;
        foreach ($bookings as $booking) {
            $count += $booking->quantity();
        }
        return $count;
    }

    public static function getCountReview($stay_id): int
    {
        return ReviewStay::find()->andWhere(['stay_id' => $stay_id])->count();
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

    public static function listGuest($max = 20)
    {
        $result[1] = '1 взрослый';
        for ($i = 2; $i <= $max; $i++) {
            $result[$i] = $i . ' взрослых';
        }
        return $result;
    }

    public static function listChildren()
    {
        $result[0] = 'Без детей';
        $result[1] = '1 ребенок';
        for ($i = 2; $i <= 8; $i++) {
            $result[$i] = $i . ' детей';
        }
        return $result;
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