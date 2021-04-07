<?php


namespace booking\entities\shops\products;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class MaterialAssign
 * @package booking\entities\shops\products
 * @property integer $shop_id
 * @property integer $material_id
 * @property Material $material
 */

abstract class BaseMaterialAssign extends ActiveRecord
{
    public static function create($material_id): self
    {
        $assign = new static();
        $assign->material_id = $material_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->material_id == $id;
    }

    public function getMaterial(): ActiveQuery
    {
        return $this->hasOne(Material::class, ['id' => 'material_id']);
    }
}