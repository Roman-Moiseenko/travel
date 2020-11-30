<?php


namespace booking\entities\booking\funs;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\BookingItemInterface;
use yii\db\ActiveRecord;

class BookingFuns extends ActiveRecord implements BookingItemInterface
{

    /** get entities */
    public function getAdmin(): User
    {
        // TODO: Implement getAdmin() method.
    }

    public function getLegal(): Legal
    {
        // TODO: Implement getLegal() method.
    }

    /** get field */
    public function getParentId(): int
    {
        // TODO: Implement getParentId() method.
    }

    public function getUserId(): int
    {
        // TODO: Implement getUserId() method.
    }

    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    public function getDate(): int
    {
        // TODO: Implement getDate() method.
    }

    public function getCreated(): int
    {
        // TODO: Implement getCreated() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getLinks(): array
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

    public function getStatus(): int
    {
        // TODO: Implement getStatus() method.
    }

    public function getAmount(): int
    {
        // TODO: Implement getAmount() method.
    }

    public function getAmountDiscount(): float
    {
        // TODO: Implement getAmountDiscount() method.
    }

    public function getMerchant(): float
    {
        // TODO: Implement getMerchant() method.
    }

    public function getAmountPayAdmin(): float
    {
        // TODO: Implement getAmountPayAdmin() method.
    }

    public function getPaymentToProvider(): float
    {
        // TODO: Implement getPaymentToProvider() method.
    }

    public function getCheckBooking(): int
    {
        // TODO: Implement getCheckBooking() method.
    }

    public function getConfirmationCode(): string
    {
        // TODO: Implement getConfirmationCode() method.
    }

    public function getPinCode(): int
    {
        // TODO: Implement getPinCode() method.
    }

    public function getCount(): int
    {
        // TODO: Implement getCount() method.
    }

    /** set */
    public function setStatus(int $status)
    {
        // TODO: Implement setStatus() method.
    }

    public function setPaymentId(string $payment_id)
    {
        // TODO: Implement setPaymentId() method.
    }

    public function setGive()
    {
        // TODO: Implement setGive() method.
    }

    /** is.. */
    public function isPay(): bool
    {
        // TODO: Implement isPay() method.
    }

    public function isConfirmation(): bool
    {
        // TODO: Implement isConfirmation() method.
    }

    public function isCancel(): bool
    {
        // TODO: Implement isCancel() method.
    }

    public function isCheckBooking(): bool
    {
        // TODO: Implement isCheckBooking() method.
    }
}