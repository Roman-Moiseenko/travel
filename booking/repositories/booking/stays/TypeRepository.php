<?php


namespace booking\repositories\booking\stays;


use booking\entities\booking\stays\Type;

class TypeRepository
{
    public function get($id): Type
    {
        if (!$result = Type::findOne('id')) {
            throw new \DomainException('Не найден тип жилища ' . $id);
        }
        return $result;
    }

    public function save(Type $type): void
    {
        if (!$type->save()) {
            throw new \RuntimeException('Тип жилища не сохранен');
        }
    }

    public function remove(Type $type)
    {
        if (!$type->delete()) {
            throw new \RuntimeException('Ошибка удаления типа жилища');
        }
    }
}