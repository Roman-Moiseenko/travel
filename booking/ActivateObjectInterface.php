<?php


namespace booking;


interface ActivateObjectInterface
{
    public function setStatus($status);

    public function isActive(): bool;

    public function isVerify(): bool;

    public function isDraft(): bool;

    public function isInactive(): bool;

    public function isLock();
}