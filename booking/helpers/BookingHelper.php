<?php


namespace booking\helpers;


use booking\entities\booking\AgeLimit;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\Car;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;

class BookingHelper
{
    const BOOKING_STATUS_NEW = 1;
    const BOOKING_STATUS_PAY = 2;
    const BOOKING_STATUS_CANCEL = 3;
    const BOOKING_STATUS_CANCEL_PAY = 4;
    const BOOKING_STATUS_EXECUTE = 5;
    const BOOKING_STATUS_CONFIRMATION = 6;

    const BOOKING_TYPE_TOUR = 1;
    const BOOKING_TYPE_STAY = 2;
    const BOOKING_TYPE_CAR = 3;
    const BOOKING_TYPE_TICKET = 4;
    const BOOKING_TYPE_FUNS = 5;

    const LIST_BOOKING_TYPE = [
        self::BOOKING_TYPE_TOUR => BookingTour::class,
        self::BOOKING_TYPE_STAY => BookingStay::class,
        self::BOOKING_TYPE_CAR => BookingCar::class,
        self::BOOKING_TYPE_TICKET => null,
        self::BOOKING_TYPE_FUNS => null,

    ];
//TODO Заглушки Funs, Stays
    const LIST_TYPE = [
        self::BOOKING_TYPE_TOUR => Tour::class,
        self::BOOKING_TYPE_STAY => Stay::class,
        self::BOOKING_TYPE_CAR => Car::class,
        self::BOOKING_TYPE_TICKET => null,
        self::BOOKING_TYPE_FUNS => null,

    ];

    const NEW_DAYS = 7; //Сколько дней после публикации считать новым

    //Бронирование оплачивается у Провайдера или на Сайте
    const BOOKING_CONFIRMATION = 101; //При оплате -> Подтверждение
    const BOOKING_PAYMENT = 102; //При оплате -> Онлайн-оплата

    public static function list(): array
    {
        return [
            self::BOOKING_STATUS_NEW => Lang::t('Новый'),
            self::BOOKING_STATUS_PAY => Lang::t('Оплачен'),
            self::BOOKING_STATUS_CANCEL => Lang::t('Отменен'),
            self::BOOKING_STATUS_CANCEL_PAY => Lang::t('Отменен после оплаты'),
            self::BOOKING_STATUS_EXECUTE => Lang::t('Исполнен'),
            self::BOOKING_STATUS_CONFIRMATION => Lang::t('Подтвержден'),
        ];
    }

    public static function listCheck(): array
    {
        return [
            self::BOOKING_CONFIRMATION => 'Оплата на месте',
            self::BOOKING_PAYMENT => 'Оплата через сервис koenigs.ru',
        ];
    }

    public static function status(BookingItemInterface $booking): string
    {
        switch ($booking->getStatus()) {
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
            /*case self::BOOKING_STATUS_EXECUTE:
                $class = 'badge badge-info';
                break;*/
            case self::BOOKING_STATUS_CONFIRMATION:
                $class = 'badge badge-info';
                break;
            default:
                $class = 'badge badge-info'; //primary info
        }

        return '<span class="' . $class . '">' . (self::list())[$booking->getStatus()] . '</span>';
    }

    public static function caption(BookingItemInterface $booking): string
    {
        return (self::list())[$booking->getStatus()];
    }

    public static function icons($type)
    {
        if ($type == self::BOOKING_TYPE_STAY) return '<i class="fas fa-hotel"></i>';
        if ($type == self::BOOKING_TYPE_TOUR) return '<i class="fas fa-map-marked-alt"></i>';
        if ($type == self::BOOKING_TYPE_CAR) return '<i class="fas fa-car"></i>';
        if ($type == self::BOOKING_TYPE_TICKET) return '<i class="fas fa-ticket-alt"></i>';
        if ($type == self::BOOKING_TYPE_FUNS) return '<i class="fas fa-hot-tub"></i>';
    }

    public static function stamp(BookingItemInterface $booking): string
    {
        if ($booking->isPay()) {
            return '<span class="big-red-paid-stamp">' . mb_strtoupper(Lang::t('ОПЛАЧЕНО')) . '</span>';
        }
        if ($booking->isConfirmation()) {
            return '<span class="big-red-paid-stamp">' . mb_strtoupper(Lang::t('ПОДТВЕРЖДЕНО')) . '</span>';
        }
        if ($booking->isCancel()) {
            return '<span class="big-grey-paid-stamp">' . mb_strtoupper(Lang::t('ОТМЕНЕНО')) . '</span>';
        }
        return '';
    }

    public static function number(BookingItemInterface $booking, $forPay = false): string
    {
        if (!$forPay)
            return $booking->getAdmin()->id . '.' . $booking->getId() . $booking->getType();
        return $booking->getId() . $booking->getType();

    }

    public static function getByNumber($number): ?BookingItemInterface
    {
        if (empty($number)) return null;
        try {
            $point = strpos($number, '.');
            //$user_id = substr($number, 0, $point);
            if ($point == 0) {
                $temp = $number;
            } else {
                $temp = substr($number, $point + 1, strlen($number) - ($point + 1));
            }
            $booking_id = intdiv((int)$temp, 10);
            $typeBooking = (int)$temp % 10;
            $class = self::LIST_BOOKING_TYPE[$typeBooking];
            return $class::findOne($booking_id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', Lang::t('Ошибка в номере бронирования') . ' => ' . $e->getMessage());
        }
    }

    public static function fieldAddToString(BookingItemInterface $booking): string
    {
        $datetime2 = $booking->getAdd();
        switch ($booking->getType()) {
            case BookingHelper::BOOKING_TYPE_TICKET:
            case BookingHelper::BOOKING_TYPE_TOUR:
            case BookingHelper::BOOKING_TYPE_FUNS:
                return $datetime2;
                break;
            case BookingHelper::BOOKING_TYPE_CAR:
            case BookingHelper::BOOKING_TYPE_STAY:
                return Lang::t('по') . ' ' . date('d-m-Y', $datetime2);
                break;
        }
    }

    public static function merchant(BookingItemInterface $booking)
    {
        if ($booking->getCheckBooking() == self::BOOKING_CONFIRMATION) return $booking->getAmountDiscount();
        if (!isset(\Yii::$app->params['merchant_payment']) && \Yii::$app->params['merchant_payment'] == false) {
            return $booking->getAmountDiscount() / (1 + $booking->getMerchant() / 100);
        } else {
            $merchant = $booking->getMerchant() == 0 ? \Yii::$app->params['merchant'] : 0;
            return $booking->getAmountDiscount() * (1 + $merchant / 100);
        }
    }

    public static function cancellation($cancellation): string
    {
        if ($cancellation === null) return Lang::t('Отмена не предусмотрена');
        if ($cancellation === 0) return Lang::t('Отмена в любое время');
        return Lang::t('Отмена за') . ' ' . $cancellation . ' ' . Lang::t('дней');
    }

    public static function ageLimit(AgeLimit $ageLimit): string
    {
        if ($ageLimit->on == null) return Lang::t('Не задано');
        if ($ageLimit->on == false) return Lang::t('нет');
        if ($ageLimit->on == true) {
            $min = empty($ageLimit->ageMin) ? '' : Lang::t('с') . ' ' . $ageLimit->ageMin . ' ' . Lang::t('лет');
            $max = empty($ageLimit->ageMax) ? '' : ' ' . Lang::t('до') . ' ' . $ageLimit->ageMax . ' ' . Lang::t('лет');
            return $min . $max;
        }
    }
}