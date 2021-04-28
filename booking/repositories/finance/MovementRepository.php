<?php


namespace booking\repositories\finance;


use booking\entities\finance\Movement;
use booking\entities\finance\Payment;

class MovementRepository
{
    public function get($id): Movement
    {
        if (!$result = Movement::findOne($id))
            throw new \DomainException('Платеж не найден ID=' . $id);
        return $result;
    }

    public function getByPaymentId(string $payment_id): Movement
    {
        if (!$result = Movement::findOne(['payment_id' => $payment_id]))
            throw new \DomainException('Платеж не найден PAYMENT_ID=' . $payment_id);
        return $result;
    }

    public function save(Movement $payment): void
    {
        if (!$payment->save()) {
            throw new \DomainException('Платеж не сохранен');
        }
    }

    public function remove(Movement $payment): void
    {
        if (!$payment->delete()) {
            throw new \DomainException('Платеж не удален');
        }
    }
}