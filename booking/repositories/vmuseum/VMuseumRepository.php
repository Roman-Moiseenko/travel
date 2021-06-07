<?php


namespace booking\repositories\vmuseum;


use booking\entities\vmuseum\VMuseum;

class VMuseumRepository
{
    public function get($id): VMuseum
    {
        if (!$result = VMuseum::findOne($id)) {
            throw new \DomainException('Музей не найден');
        }
        return $result;
    }

    public function save(VMuseum $material)
    {
        if (!$material->save()) {
            throw new \DomainException('Музей не сохранен');
        }
    }

    public function remove(VMuseum $material)
    {
        if (!$material->delete()) {
            throw new \DomainException('Ошибка удаления музея');
        }
    }
}