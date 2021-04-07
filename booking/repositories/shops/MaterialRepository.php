<?php


namespace booking\repositories\shops;


use booking\entities\shops\products\Material;

class MaterialRepository
{
    public function get($id): Material
    {
        if (!$result = Material::findOne($id)) {
            throw new \DomainException('Материал не найден');
        }
        return $result;
    }

    public function save(Material $material)
    {
        if (!$material->save()) {
            throw new \DomainException('Материал не сохранен');
        }
    }

    public function remove(Material $material)
    {
        if (!$material->delete()) {
            throw new \DomainException('Ошибка удаления материала');
        }
    }
}