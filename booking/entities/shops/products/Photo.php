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
 * @property Product $main
 * @mixin ImageUploadBehavior
 */

class Photo extends BasePhoto
{

    protected $catalog = 'products';
    protected $name_id = 'prduct_id';

    public static function tableName()
    {
        return '{{%shops_product_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);

    }

    public function getName(): string
    {
        return $this->main->getName();
    }

    public function getDescription(): string
    {
        return $this->main->getDescription();
    }
}