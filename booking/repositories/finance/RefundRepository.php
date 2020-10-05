<?php


namespace booking\repositories\finance;


use booking\entities\finance\Refund;

class RefundRepository
{
    public function get($id): Refund
    {
        if (!$result = Refund::findOne($id))
            throw new \DomainException('Возврат не найден ID=' . $id);
    }

    public function save(Refund $refund): void
    {
        if (!$refund->save()) {
            throw new \DomainException('Возврат не сохранен');
        }
    }

    public function remove(Refund $refund): void
    {
        if (!$refund->delete()) {
            throw new \DomainException('Возврат не удален');
        }
    }

}
