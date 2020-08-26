<?php


namespace booking\entities\booking;


interface BookingItemInterface
{
    public function getAdminId(): int;
    public function getUserId(): int;
    public function getId(): int;
    public function getDate(): int;
    public function getName(): string;
    public function getLink(): string;
    public function getPhoto(): string;
    public function getType(): string;
    public function getAdd(): string;
    public function getStatus(): int;
    public function getAmount(): int;
    public function setStatus(int $status);

}