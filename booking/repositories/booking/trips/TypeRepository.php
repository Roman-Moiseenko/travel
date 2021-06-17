<?php


namespace booking\repositories\booking\trips;

use booking\entities\booking\trips\Type;

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

    public function findBySlug($slug)
    {
        return Type::find()->andWhere(['slug' => $slug])->one();
    }

    public function find($id):? Type
    {
        return Type::findOne($id);
    }
}