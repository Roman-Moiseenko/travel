<?php


namespace booking\repositories\finance;


use booking\entities\finance\Payment;

class PaymentRepository
{
    public function get($id): Payment
    {
        if (!$result = Payment::findOne($id))
            throw new \DomainException('Выплата не найдена ID=' . $id);
    }

    public function save(Payment $payment): void
    {
        if (!$payment->save()) {
            throw new \DomainException('Выплата не сохранена');
        }
    }

    public function remove(Payment $payment): void
    {
        if (!$payment->delete()) {
            throw new \DomainException('Выплата не удалена');
        }
    }
}