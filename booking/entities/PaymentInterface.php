<?php


namespace booking\entities;


use booking\entities\admin\Legal;
use booking\entities\booking\Payment;

interface PaymentInterface
{
    public function getId(): int;
    public function getLegal(): Legal;
    public function getPayment(): Payment;
}