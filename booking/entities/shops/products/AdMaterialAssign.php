<?php


namespace booking\entities\shops\products;

/**
 * Class AdMaterialAssign
 * @package booking\entities\shops\products
 * @property integer $material_id
 * @property integer $product_id
 */
class AdMaterialAssign extends BaseMaterialAssign
{
    public static function tableName()
    {
        return '{{%shops_ad_product_material_assign}}';
    }

}