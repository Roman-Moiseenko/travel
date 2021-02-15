<?php


namespace booking\repositories\office\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;

class StayComfortRepository
{

    public function get($id): Comfort
    {
        if (!$result = Comfort::findOne($id)) {
            throw new \DomainException('Удобство не найдено');
        }
        return $result;
    }

    public function getAll()
    {
        return Comfort::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function save(Comfort $comfort): void
    {
        if (!$comfort->save()) {
            throw new \RuntimeException('Удобство не сохранено');
        }
    }

    public function remove(Comfort $comfort)
    {
        if (!$comfort->delete()) {
            throw new \RuntimeException('Ошибка удаления удобства');
        }
    }

    public function getMaxSort()
    {
        return Comfort::find()->max('sort');
    }

    public function getCategory($id): ComfortCategory
    {
        if (!$result = ComfortCategory::findOne($id)) {
            throw new \DomainException('Категория удобства не найдена');
        }
        return $result;
    }

    public function getAllCategory()
    {
        return ComfortCategory::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function saveCategory(ComfortCategory $comfort): void
    {
        if (!$comfort->save()) {
            throw new \RuntimeException('Категория удобства не сохранена');
        }
    }

    public function removeCategory(ComfortCategory $comfort)
    {
        if (!$comfort->delete()) {
            throw new \RuntimeException('Ошибка удаления категория удобства');
        }
    }

    public function getMaxSortCategory()
    {
        return ComfortCategory::find()->max('sort');
    }


}