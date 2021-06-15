<?php


namespace booking\entities\booking\trips;


use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\LinkBooking;
use yii\db\ActiveQuery;

class BookingTrip extends BaseBooking
{

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

    public function getInfoNotice(): string
    {
        // TODO: Implement getInfoNotice() method.
    }

    public function isCancellation(): bool
    {
        // TODO: Implement isCancellation() method.
    }
}