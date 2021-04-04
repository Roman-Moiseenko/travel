<?php


namespace booking\entities\shops\products;


use yii\db\ActiveRecord;

/**
 * Class MaterialAssign
 * @package booking\entities\shops\products
 * @property integer $shop_id
 * @property integer $material_id
 */

class MaterialAssign extends ActiveRecord
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

    public static function tableName()
    {
        return '{{%shops_product_material_assign}}';
    }
}