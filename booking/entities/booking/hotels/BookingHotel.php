<?php


namespace booking\entities\booking\hotels;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\BookingObject;
use booking\entities\booking\tours\Cost;

class BookingHotel extends BookingObject
{

    public static function create($idcalendar = null, Cost $cost = null): BookingObject
    {
        // TODO: Implement create() method.
    }

    public function getAmount(): int
    {
        // TODO: Implement getAmount() method.

    }

    public function getAmountDiscount(): float
    {
        // TODO: Implement getAmountDiscount() method.
    }

    public function getAmountPayAdmin(): float
    {
        // TODO: Implement getAmountPayAdmin() method.
    }

    public function getPaymentToProvider(): float
    {
        // TODO: Implement getPaymentToProvider() method.
    }

    public function getDate(): int
    {
        // TODO: Implement getDate() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getLinks(): array
    {
        // TODO: Implement getLinks() method.
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
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

    public function getAdmin(): User
    {
        // TODO: Implement getAdmin() method.
    }

    public function getLegal(): Legal
    {
        // TODO: Implement getLegal() method.
    }

    public function getParentId(): int
    {
        // TODO: Implement getParentId() method.
    }

    public function getCount(): int
    {
        // TODO: Implement getCount() method.
    }

    public function isCheckBooking(): bool
    {
        // TODO: Implement isCheckBooking() method.
    }
}