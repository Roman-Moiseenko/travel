<?php


namespace booking\entities\shops\products;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $product_id
 * @property string $alt
 * @property BaseProduct $main
 * @mixin ImageUploadBehavior
 */

class AdPhoto extends BasePhoto
{

    protected $catalog = 'products';
    protected $name_id = 'prduct_id';

    public static function tableName()
    {
        return '{{%shops_ad_product_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(BaseProduct::class, ['id' => 'product_id']);

    }

}