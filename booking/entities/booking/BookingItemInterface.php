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
    public function getPhoto(string $photo = ''): string;
    public function getType(): string;
    public function getAdd(): string;
    public function getStatus(): int;
    public function getAmount(): int; //Базовая сумма
    public function getAmountDiscount(): float; //С учетом скидок

    //TODO удалить, заменив вывод в ... admin->...->booking
    public function getAmountPayAdmin(): float; //Удалить
    public function getPaymentToProvider(): float; //Выплата провайдеру
    public function getConfirmationCode(): string;
    public function getPinCode(): int;
    public function getCount(): int;

    /** set */
    public function setStatus(int $status);
    public function setPaymentId(string $payment_id);
    public function setGive();

    /** is.. */
    public function isPay(): bool;
    public function isNew(): bool;
    public function isConfirmation(): bool;
    public function isCancel(): bool;
    public function isCheckBooking(): bool; //Оплата через сайт (true) или на месте (false)



}