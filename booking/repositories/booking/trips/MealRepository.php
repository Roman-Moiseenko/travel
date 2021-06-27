<?php


namespace booking\repositories\booking\trips;

use booking\entities\booking\Meals;

class MealRepository
{
    public function get($id): Meals
    {
        if (!$result = Meals::findOne($id)) {
            throw new \DomainException('Не найдена категория питания ' . $id);
        }
        return $result;
    }

    public function save(Meals $type): void
    {
        if (!$type->save()) {
            throw new \DomainException('Категория питания не сохранен');
        }
    }

    public function remove(Meals $type)
    {
        if (!$type->delete()) {
            throw new \DomainException('Ошибка удаления категории питания');
        }
    }

    public function getMaxSort()
    {
        return Meals::find()->max('sort');
    }

    public function getAll()
    {
        return Meals::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getMinSort()
    {
        return Meals::find()->min('sort');
    }

    public function find($id):? Meals
    {
        return Meals::findOne($id);
    }
}