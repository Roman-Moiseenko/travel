<?php


namespace booking\entities\booking;


interface BookingItemInterface
{
    public function getDate(): int;
    public function getName(): string;
    public function getLink(): string;
    public function getPhoto(): string;
    public function getType(): string;
    public function getAdd(): string;
    public function getStatus(): int;
    public function getAmount(): int;

}