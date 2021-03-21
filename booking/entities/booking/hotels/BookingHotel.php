<?php


namespace booking\entities\booking\hotels;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\BookingObject;
use booking\entities\booking\LinkBooking;
use booking\entities\booking\tours\Cost;
use yii\db\ActiveQuery;

class BookingHotel extends BaseBooking
{

    public static function create($idcalendar = null, Cost $cost = null): BaseBooking
    {
        // TODO: Implement create() method.
    }

    public function getAdmin(): User
    {
        // TODO: Implement getAdmin() method.
    }

    public function getDate(): int
    {
        // TODO: Implement getDate() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getLinks(): LinkBooking
    {
        // TODO: Implement getLinks() method.
    }

    public function getPhoto(string $photo = ''): string
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

    public function quantity(): int
    {
        // TODO: Implement quantity() method.
    }

    public function isPaidLocally(): bool
    {
        // TODO: Implement isPaidLocally() method.
    }

    public function getCalendar(): ActiveQuery
    {
        // TODO: Implement getCalendar() method.
    }

    public function getCalendars(): ActiveQuery
    {
        // TODO: Implement getCalendars() method.
    }

    public function getDays(): ActiveQuery
    {
        // TODO: Implement getDays() method.
    }

    protected function getFullCostFrom(): float
    {
        // TODO: Implement getFullCostFrom() method.
    }

    protected function getPrepayFrom(): int
    {
        // TODO: Implement getPrepayFrom() method.
    }
}