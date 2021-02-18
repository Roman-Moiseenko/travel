<?php


namespace booking\repositories\booking\stays\bedroom;


use booking\entities\booking\stays\bedroom\TypeOfBed;
use booking\entities\Lang;

class TypeOfBedRepository
{
    public function get($id): TypeOfBed
    {
        if (!$type = TypeOfBed::findOne($id)) {
            throw new \DomainException(Lang::t('Тип кровати не найден'));
        }
        return $type;
    }

    public function save(TypeOfBed $type): void
    {
        if (!$type->save()) {
            throw new \DomainException(Lang::t('Тип кровати не сохранен'));
        }
    }

    public function remove(TypeOfBed $type)
    {
        if (!$type->delete()) {
            throw new \DomainException(Lang::t('Ошибка удаления Типа кровати'));
        }
    }
}