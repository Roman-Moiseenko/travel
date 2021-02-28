<?php


namespace booking\repositories\office\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;

class StayComfortRoomRepository
{

    public function get($id): ComfortRoom
    {
        if (!$result = ComfortRoom::findOne($id)) {
            throw new \DomainException('Удобство не найдено');
        }
        return $result;
    }

    public function getAll()
    {
        return ComfortRoom::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function save(ComfortRoom $comfort): void
    {
        if (!$comfort->save()) {
            throw new \DomainException('Удобство не сохранено');
        }
    }

    public function remove(ComfortRoom $comfort)
    {
        if (!$comfort->delete()) {
            throw new \DomainException('Ошибка удаления удобства');
        }
    }

    public function getMaxSort()
    {
        return ComfortRoom::find()->max('sort');
    }

    public function getCategory($id): ComfortRoomCategory
    {
        if (!$result = ComfortRoomCategory::findOne($id)) {
            throw new \DomainException('Категория удобства не найдена');
        }
        return $result;
    }

    public function getAllCategory()
    {
        return ComfortRoomCategory::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function saveCategory(ComfortRoomCategory $comfort): void
    {
        if (!$comfort->save()) {
            throw new \DomainException('Категория удобства не сохранена');
        }
    }

    public function removeCategory(ComfortRoomCategory $comfort)
    {
        if (!$comfort->delete()) {
            throw new \DomainException('Ошибка удаления категория удобства');
        }
    }

    public function getMaxSortCategory()
    {
        return ComfortRoomCategory::find()->max('sort');
    }


}