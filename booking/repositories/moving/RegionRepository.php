<?php


namespace booking\repositories\moving;


use booking\entities\moving\agent\Region;

class RegionRepository
{
    public function get($id): Region
    {
        if (!$region = Region::findOne($id)) {
            throw new \DomainException('Регион не найден.');
        }
        return $region;
    }

    public function save(Region $region): void
    {
        if (!$region->save()) {
            throw new \DomainException('Ошибка сохранения Региона.');
        }
    }
    public function remove(Region $region): void
    {
        if (!$region->delete()) {
            throw new \DomainException('Ошибка удаления Региона.');
        }
    }

    public function getMaxSort()
    {
        return Region::find()->max('sort');
    }

    public function getAll()
    {
        return Region::find()->orderBy(['sort' => SORT_ASC])->all();
    }
}