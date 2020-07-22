<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\StaysType;

class StaysTypeRepository
{
    public function get($id): StaysType
    {
        if (!$result = StaysType::findOne('id')) {
            throw new \DomainException('Не найден тип жилища ' . $id);
        }
        return $result;
    }

    public function save(StaysType $staysType): void
    {
        if (!$staysType->save()) {
            throw new \RuntimeException('Тип жилища не сохранен');
        }
    }

    public function remove(StaysType $roomsType)
    {
        if (!$staysType->delete()) {
            throw new \RuntimeException('Ошибка удаления типа жилища');
        }
    }
}