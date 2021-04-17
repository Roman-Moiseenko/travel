<?php


namespace booking\entities\shops\products;

use booking\entities\shops\AdShop;
use booking\entities\shops\products\queries\AdProductQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;

/**
 * Class AdProduct
 * @package booking\entities\shops\products
 * @property AdShop $shop
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property MaterialAssign[] $materialAssign
 * @property Material[] $materials
 */

class AdProduct extends BaseProduct
{
    public static function create($name, $name_en, $description, $description_en,
                                  $weight, $size, $article, $collection, $color,
                                  $manufactured_id, $category_id, $cost, $discount
                                  ): self
    {
        $product = new static($name, $name_en, $description, $description_en,
            $weight, $size, $article, $collection, $color,
            $manufactured_id, $category_id, $cost, $discount);

        return $product;
    }

    public static function costActive()
    {
        //TODO Вынести в Office Ценообразование priceList->productAd
        return 1;
    }

    public function edit($name, $name_en, $description, $description_en,
                         $weight, $size, $article, $collection, $color,
                         $manufactured_id, $category_id, $cost, $discount
                         ): void
    {
        $this->name = $name;
        $this->name_en = $name_en;
        $this->description = $description;
        $this->description_en = $description_en;

        $this->weight = $weight;
        $this->size = $size;
        $this->article = $article;
        $this->collection = $collection;
        $this->color = $color;

        $this->manufactured_id = $manufactured_id;
        $this->category_id = $category_id;
        $this->cost = $cost;
        $this->discount = $discount;
    }

    public static function tableName()
    {
        return '{{%shops_ad_product}}';
    }
    public function behaviors()
    {
        $new = [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'materialAssign',
                ],
            ],
        ];
        $old = parent::behaviors();
        return array_merge($new, $old);
    }
    public function clearMaterial()
    {
        $this->materialAssign = [];
    }

    public function assignMaterial($material)
    {
        $assign = $this->materialAssign;
        $assign[] = AdMaterialAssign::create($material);
        $this->materialAssign = $assign;
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(AdPhoto::class, ['product_id' => 'id']);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(AdPhoto::class, ['id' => 'main_photo_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(AdReviewProduct::class, ['product_id' => 'id']);
    }

    public static function find(): AdProductQuery
    {
        return new AdProductQuery(static::class);
    }

    public function getMaterialAssign(): ActiveQuery
    {
        return $this->hasMany(AdMaterialAssign::class, ['product_id' => 'id']);
    }

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(AdShop::class, ['id' => 'shop_id']);
    }

    public function isAd(): bool
    {
        return true;
    }
}