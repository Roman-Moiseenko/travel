<?php


namespace booking\entities;


use booking\entities\admin\Legal;
use booking\entities\booking\Payment;
use booking\entities\user\User;

interface PaymentInterface
{
    public function getUserId(): int;
    public function getId(): int;
    public function getLegal(): Legal;
    public function getPayment(): Payment;
    public function getName(): string;
}