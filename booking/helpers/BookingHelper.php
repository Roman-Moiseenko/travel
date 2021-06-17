<?php


namespace booking\helpers;


use booking\entities\booking\AgeLimit;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\hotels\BookingHotel;
use booking\entities\booking\hotels\Hotel;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
use booking\entities\booking\trips\BookingTrip;
use booking\entities\booking\trips\Trip;
use booking\entities\Lang;

class BookingHelper
{
    const BOOKING_STATUS_NEW = 1;
    const BOOKING_STATUS_PAY = 2;
    const BOOKING_STATUS_CANCEL = 3;
    const BOOKING_STATUS_CANCEL_PAY = 4;
    const BOOKING_STATUS_EXECUTE = 5;
    const BOOKING_STATUS_CONFIRMATION = 6;
    const BOOKING_STATUS_SELLING = 7; //Прямая продажа
    const BOOKING_STATUS_RESERVATION = 8; //Зарезервирован

    const BOOKING_TYPE_TOUR = 1;
    const BOOKING_TYPE_STAY = 2;
    const BOOKING_TYPE_CAR = 3;
    const BOOKING_TYPE_TICKET = 4;
    const BOOKING_TYPE_FUNS = 5;
    const BOOKING_TYPE_HOTEL = 6;
    const BOOKING_TYPE_TRIP = 7;

    //******* Не бронируемые типы  ****/
    const BOOKING_TYPE_FOOD = 106;
    const BOOKING_TYPE_SHOP = 107;
    const BOOKING_TYPE_PRODUCT = 108;
    const BOOKING_TYPE_VMUSEUM = 109;

    const LIST_BOOKING_TYPE = [
        self::BOOKING_TYPE_TOUR => BookingTour::class,
        self::BOOKING_TYPE_STAY => BookingStay::class,
        self::BOOKING_TYPE_CAR => BookingCar::class,
        self::BOOKING_TYPE_TICKET => null,
        self::BOOKING_TYPE_FUNS => BookingFun::class,
        self::BOOKING_TYPE_HOTEL => BookingHotel::class,
        self::BOOKING_TYPE_TRIP => BookingTrip::class,
    ];
//TODO Заглушки Stays
    const LIST_TYPE = [
        self::BOOKING_TYPE_TOUR => Tour::class,
        self::BOOKING_TYPE_STAY => Stay::class,
        self::BOOKING_TYPE_CAR => Car::class,
        self::BOOKING_TYPE_TICKET => null,
        self::BOOKING_TYPE_FUNS => Fun::class,
        self::BOOKING_TYPE_HOTEL => Hotel::class,
        self::BOOKING_TYPE_TRIP => Trip::class,
    ];

    const TYPE_OF_LIST = [
        Tour::class => self::BOOKING_TYPE_TOUR,
        Stay::class => self::BOOKING_TYPE_STAY,
        Car::class => self::BOOKING_TYPE_CAR,
        //null => self::BOOKING_TYPE_TICKET,
        Fun::class => self::BOOKING_TYPE_FUNS,
        Hotel::class => self::BOOKING_TYPE_HOTEL,
        Trip::class => self::BOOKING_TYPE_TRIP,
    ];

    const STRING_TYPE = [
        self::BOOKING_TYPE_TOUR => 'Экскурсии',
        self::BOOKING_TYPE_STAY => 'Апартаменты и дома',
        self::BOOKING_TYPE_CAR => 'Прокат авто',
        self::BOOKING_TYPE_TICKET => 'Билеты на концерты',
        self::BOOKING_TYPE_FUNS => 'Развлечения и мероприятия',
        self::BOOKING_TYPE_HOTEL => 'Отели и базы отдыха',
        self::BOOKING_TYPE_TRIP => 'Туры',
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
            self::BOOKING_STATUS_RESERVATION => Lang::t('Зарезервирован'),
        ];
    }

    public static function listCheck(): array
    {
        return [
            self::BOOKING_CONFIRMATION => 'Оплата на месте',
            self::BOOKING_PAYMENT => 'Оплата через сервис koenigs.ru',
        ];
    }

    public static function status(BaseBooking $booking): string //BookingItemInterface
    {
        switch ($booking->getStatus()) {
            case self::BOOKING_STATUS_NEW:
            case self::BOOKING_STATUS_RESERVATION:
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

    public static function caption(BaseBooking $booking): string //BookingItemInterface
    {
        return (self::list())[$booking->getStatus()];
    }

    public static function icons($type)
    {
        if ($type == self::BOOKING_TYPE_STAY) return '<i class="fas fa-house-user"></i>';
        if ($type == self::BOOKING_TYPE_HOTEL) return '<i class="fas fa-hotel"></i>';
        if ($type == self::BOOKING_TYPE_TOUR) return '<i class="fas fa-map-marked-alt"></i>';
        if ($type == self::BOOKING_TYPE_CAR) return '<i class="fas fa-car"></i>';
        if ($type == self::BOOKING_TYPE_TICKET) return '<i class="fas fa-ticket-alt"></i>';
        if ($type == self::BOOKING_TYPE_FUNS) return '<i class="fas fa-hot-tub"></i>';
        if ($type == self::BOOKING_TYPE_TRIP) return '<i class="fas fa-suitcase"></i>';


        //******* Не бронируемые типы  ****/
        if ($type == self::BOOKING_TYPE_FOOD) return '<i class="fas fa-utensils"></i>';
        if ($type == self::BOOKING_TYPE_SHOP) return '<i class="fas fa-store"></i>';
        if ($type == self::BOOKING_TYPE_VMUSEUM) return '<i class="fas fa-dungeon"></i>';

        throw new \DomainException('Не известный тип');
    }

    public static function stamp(BaseBooking $booking): string //BookingItemInterface
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

    public static function number(BaseBooking $booking, $forPay = false): string //BookingItemInterface
    {
        if (!$forPay)
            return $booking->getAdmin()->id . '.' . $booking->getId() . $booking->getType();
        return $booking->getId() . $booking->getType();

    }

    public static function getByNumber($number): ?BaseBooking //BookingItemInterface
    {
        if (empty($number)) return null;
        try {
            $point = strpos($number, '.');
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

    public static function fieldAddToString(BaseBooking $booking): string//BookingItemInterface
    {
        $datetime2 = $booking->getAdd();
        switch ($booking->getType()) {
            case BookingHelper::BOOKING_TYPE_TICKET:
            case BookingHelper::BOOKING_TYPE_TOUR:
            case BookingHelper::BOOKING_TYPE_FUNS:
                return $datetime2;
                break;
            case BookingHelper::BOOKING_TYPE_CAR:
            case BookingHelper::BOOKING_TYPE_HOTEL:
            case BookingHelper::BOOKING_TYPE_STAY:
                return Lang::t('по') . ' ' . $datetime2;
                break;
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

    public static function listPrepay()
    {
        return isset(\Yii::$app->params['prepay']) ? \Yii::$app->params['prepay'] : [0 => 0, 20 => 20, 50 => 50, 100 => 100,];
    }
}