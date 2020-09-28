<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\Type;

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
            throw new \RuntimeException('Категория тура не сохранен');
        }
    }

    public function remove(Type $type)
    {
        if (!$type->delete()) {
            throw new \RuntimeException('Ошибка удаления категории тура');
        }
    }

    public function getMaxSort()
    {
        return Type::find()->max('sort');
    }

    public function getAll()
    {
        return Type::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getMinSort()
    {
        return Type::find()->min('sort');
    }
}