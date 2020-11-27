<?php


namespace booking\helpers;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\funs\BookingFuns;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;

class DiscountHelper
{

    public static function listEntities(): array
    {
        return [
            User::class => 'Все организации',
            Legal::class => 'Все объекты организации',
            BookingTour::class => 'Туры',
            BookingCar::class => 'Авто',
            BookingFuns::class => 'Отдых',
            BookingStay::class => 'Жилища',
        ];
    }
}