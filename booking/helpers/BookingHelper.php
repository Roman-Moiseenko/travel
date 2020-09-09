<?php


namespace booking\helpers;


use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\Lang;

class BookingHelper
{
    const BOOKING_STATUS_NEW = 1;
    const BOOKING_STATUS_PAY = 2;
    const BOOKING_STATUS_CANCEL = 3;
    const BOOKING_STATUS_CANCEL_PAY = 4;
    const BOOKING_STATUS_EXECUTE = 5;

    const BOOKING_TYPE_TOUR = 1;
    const BOOKING_TYPE_STAY = 2;
    const BOOKING_TYPE_CAR = 3;
    const BOOKING_TYPE_TICKET = 4;
    const LIST_BOOKING_TYPE = [
        self::BOOKING_TYPE_TOUR => BookingTour::class,
        self::BOOKING_TYPE_STAY => BookingStay::class,
        self::BOOKING_TYPE_CAR => BookingCar::class,
        self::BOOKING_TYPE_TICKET => null,

        ];

    public static function list(): array
    {
        return [
            self::BOOKING_STATUS_NEW => Lang::t('Ждет оплаты'),
            self::BOOKING_STATUS_PAY => Lang::t('Оплачен'),
            self::BOOKING_STATUS_CANCEL => Lang::t('Отменен'),
            self::BOOKING_STATUS_EXECUTE => Lang::t('Исполнен'),
        ];
    }

    public static function status($status): string
    {
        switch ($status) {
            case self::BOOKING_STATUS_NEW:
                $class = 'badge badge-warning';
                break;
            case self::BOOKING_STATUS_PAY:
                $class = 'badge badge-success';
                break;
            case self::BOOKING_STATUS_CANCEL:
            case self::BOOKING_STATUS_CANCEL_PAY:
                $class = 'badge badge-secondary';
                break;
            case self::BOOKING_STATUS_EXECUTE:
                $class = 'badge badge-info';
                break;
            default:
                $class = 'badge badge-info'; //primary info
        }

        return '<span class="' . $class . '">' . (self::list())[$status] . '</span>';
    }

    public static function caption($status): string
    {
        return (self::list())[$status];
    }

    public static function icons($type)
    {
        if ($type == self::BOOKING_TYPE_STAY) return '<i class="fas fa-hotel"></i>';
        if ($type == self::BOOKING_TYPE_TOUR) return '<i class="fas fa-map-marked-alt"></i>';
        if ($type == self::BOOKING_TYPE_CAR) return '<i class="fas fa-car"></i>';
        if ($type == self::BOOKING_TYPE_TICKET) return '<i class="fas fa-ticket-alt"></i>';
    }

    public static function stamp($status): string
    {
        if ($status == BookingHelper::BOOKING_STATUS_PAY) {
            return '<span class="big-red-paid-stamp">' . Lang::t('ОПЛАЧЕНО') . '</span>';
        }
        if ($status == BookingHelper::BOOKING_STATUS_CANCEL) {
            return '<span class="big-grey-paid-stamp">' . Lang::t('ОТМЕНЕНО') . '</span>';
        }
        return '';
    }

    public static function number(BookingItemInterface $booking): string
    {
        return $booking->getUserId() . '.' . $booking->getId() . $booking->getType();
    }

    public static function getByNumber($number):? BookingItemInterface
    {
        if (empty($number)) return null;
        try {
            $point = strpos($number, '.');
            //$user_id = substr($number, 0, $point);
            $temp = substr($number, $point + 1, strlen($number) - ($point + 1));
            $booking_id = intdiv((int)$temp, 10);
            $typeBooking = (int)$temp % 10;
            $class = self::LIST_BOOKING_TYPE[$typeBooking];
            return $class::findOne($booking_id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', Lang::t('Ошибка в номере бронирования') . ' => ' . $e->getMessage());
        }
    }
}