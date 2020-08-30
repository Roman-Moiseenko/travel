<?php


namespace booking\entities\booking;


use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;

interface ReviewInterface
{
    /** get entities */
    public function getAdmin(): User;
    public function getLegal(): UserLegal;
    /** get field */
    public function getId(): int;
    public function getLinks(): array;
    public function getText(): string;
    public function getVote(): string;
    public function getUserId(): string;
    public function getDate(): int;
    public function getType(): int;
    public function getName(): string;
}