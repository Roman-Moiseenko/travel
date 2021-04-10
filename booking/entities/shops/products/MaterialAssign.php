<?php


namespace booking\entities\shops\products;

/**
 * Class MaterialAssign
 * @package booking\entities\shops\products
 * @property integer $material_id
 * @property integer $product_id
 */
class MaterialAssign extends BaseMaterialAssign
{

    public static function tableName()
    {
        return '{{%shops_product_material_assign}}';
    }

}