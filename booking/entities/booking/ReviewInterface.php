<?php


namespace booking\entities\booking;


use booking\entities\admin\User;
use booking\entities\admin\Legal;

interface ReviewInterface
{
    /** get entities */
    public function getAdmin(): User;
    public function getLegal(): Legal;
    /** get field */
    public function getId(): int;
    public function getLinks(): array;
    public function getText(): string;
    public function getVote(): int;
    public function getUserId(): string;
    public function getDate(): int;
    public function getType(): int;
    public function getName(): string;
}