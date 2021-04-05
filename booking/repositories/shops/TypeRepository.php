<?php


namespace booking\repositories\shops;


use booking\entities\shops\TypeShop;

class TypeRepository
{

    public function get($id): TypeShop
    {
        if (!$result = TypeShop::findOne($id)) {
            throw new \DomainException('Тип магазина не найден');
        }
        return $result;
    }

    public function save(TypeShop $shopsType)
    {
        if (!$shopsType->save()) {
            throw new \DomainException('Тип магазина не сохранен');
        }
    }

    public function remove(TypeShop $shopsType)
    {
        if (!$shopsType->delete()) {
            throw new \DomainException('Ошибка удаления тип магазина');
        }
    }

}