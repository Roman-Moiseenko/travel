<?php


namespace booking\helpers;


use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;

class BookingHelper
{
    const BOOKING_STATUS_NEW = 1;
    const BOOKING_STATUS_PAY = 2;
    const BOOKING_STATUS_CANCEL = 3;
    const BOOKING_STATUS_CANCEL_PAY = 4;
    const BOOKING_STATUS_EXECUTE = 5;

    const BOOKING_TYPE_TOUR = 10;
    const BOOKING_TYPE_STAY = 20;
    const BOOKING_TYPE_CAR = 30;
    const BOOKING_TYPE_TICKET = 40;


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
        return $booking->getUserId() . '.' . $booking->getId() . $booking->getType() / 10;
    }
}