<?php


namespace booking\helpers;


use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;

class DiscountHelper
{

    public static function listEntities(): array
    {
        return [
            User::class => 'Все организации',
            UserLegal::class => 'Все объекты организации',
            BookingTour::class => 'Туры',
            BookingStay::class => 'Жилища',
            BookingCar::class => 'Авто'
        ];
    }
}