<?php


namespace booking\entities\booking;


use booking\entities\admin\User;
use booking\entities\admin\Legal;

interface BookingItemInterface
{
    /** get entities */
    public function getAdmin(): User;
    public function getLegal(): Legal;
    /** get field */
    public function getParentId(): int; //return id Tour/Stay/Car
    public function getUserId(): int;
    public function getId(): int;
    public function getDate(): int;
    public function getCreated(): int;
    public function getName(): string;
    public function getLinks(): array;
    public function getPhoto(string $photo): string;
    public function getType(): string;
    public function getAdd(): string;
    public function getStatus(): int;
    public function getAmount(): int; //Базовая сумма
    public function getAmountDiscount(): float; //С учетом скидок
    public function getMerchant(): float;
    public function getAmountPayAdmin(): float;
    public function getPaymentToProvider(): float;


    public function getConfirmation(): string;
    public function getPinCode(): int;
    /** set */
    public function setStatus(int $status);


}