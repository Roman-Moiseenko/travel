<?php


namespace booking\repositories\land;


use booking\entities\realtor\land\Land;

class LandRepository
{
    public function get($id): Land
    {
        if (!$result = Land::findOne($id)) {
            throw new \DomainException('Зем.участок не найден');
        }
        return $result;
    }


    public function save(Land $land): void
    {
        if (!$land->save()) {
            throw new \DomainException('Зем.участок не сохранен');
        }
    }

    public function remove(Land $land)
    {
        if (!$land->delete()) {
            throw new \DomainException('Ошибка удаления зем.участка');
        }
    }

    public function getAll()
    {
        return Land::find()->all();
    }
}