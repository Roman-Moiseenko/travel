<?php


namespace booking\entities\booking\cars;


use booking\entities\booking\BookingItemInterface;
use yii\db\ActiveRecord;

class BookingCar extends ActiveRecord implements BookingItemInterface
{

    public static function tableName()
    {
        return '{{%booking_cars_calendar_booking}}';
    }

    /** ==========> Interface для личного кабинета */

    public function getDate(): int
    {
        // TODO: Implement getDate() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getLink(): string
    {
        // TODO: Implement getLink() method.
    }

    public function getPhoto(): string
    {
        // TODO: Implement getPhoto() method.
    }

    public function getType(): string
    {
        // TODO: Implement getType() method.
    }

    public function getAdd(): string
    {
        // TODO: Implement getAdd() method.
    }

    public function getStatus(): int
    {
        // TODO: Implement getStatus() method.
    }

    public function getAmount(): int
    {
        // TODO: Implement getAmount() method.
    }

    public function setStatus($status)
    {
        // TODO: Implement setStatus() method.
    }
}