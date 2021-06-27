<?php


namespace booking\repositories\booking\trips\placement;



use booking\entities\booking\trips\placement\Type;

class TypeRepository
{
    public function get($id): Type
    {
        if (!$result = Type::findOne($id)) {
            throw new \DomainException('Не найдена категория тура ' . $id);
        }
        return $result;
    }

    public function save(Type $type): void
    {
        if (!$type->save()) {
            throw new \DomainException('Категория тура не сохранен');
        }
    }

    public function remove(Type $type)
    {
        if (!$type->delete()) {
            throw new \DomainException('Ошибка удаления категории тура');
        }
    }

}