<?php


namespace booking\entities\booking;


interface WishlistItemInterface
{

    public function isFor($product_id): bool;

    public function getName(): string;
    public function getLink(): string;
    public function getRemoveLink(): string;
    public function getPhoto(): string;
    public function getType(): string;
    public function getId(): int;
}