<?php


namespace booking\entities\booking;


interface WishlistItemInterface
{
    public function getName(): string;
    public function getLink(): string;
    public function getPhoto(): string;
    public function getType(): string;
}