<?php


namespace booking\entities\booking;


use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;

interface BookingItemInterface
{
    /** get entities */
    public function getAdmin(): User;
    public function getLegal(): UserLegal;
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
    public function getAmount(): int;
    public function getAmountPay(): int;
    public function getAmountPayAdmin(): int;
    /** set */
    public function setStatus(int $status);


}