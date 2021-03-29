<?php


namespace booking\repositories\foods;


use booking\entities\foods\Kitchen;

class KitchenRepository
{
    public function get($id): Kitchen
    {
        if (!$result = Kitchen::findOne($id)) {
            throw new \DomainException('Кухня не найдена');
        }
        return $result;
    }

    public function save(Kitchen $kitchen): void
    {
        if (!$kitchen->save()) {
            throw new \DomainException('Кухня не сохранена');
        }
    }

    public function remove(Kitchen $kitchen)
    {
        if (!$kitchen->delete()) {
            throw new \DomainException('Ошибка удаления кухни');
        }
    }
}