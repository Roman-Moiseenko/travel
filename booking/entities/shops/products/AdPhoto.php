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
 * @property AdProduct $main
 * @mixin ImageUploadBehavior
 */

class AdPhoto extends BasePhoto
{

    protected $catalog = 'products_ad';
    protected $name_id = 'product_id';

    public static function tableName()
    {
        return '{{%shops_ad_product_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(AdProduct::class, ['id' => 'product_id']);

    }

}