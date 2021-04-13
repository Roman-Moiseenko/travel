<?php


namespace booking\entities\shops\products;


use booking\entities\shops\products\queries\ProductQuery;
use booking\entities\shops\Shop;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property ReviewProduct[] $reviews
 * @property integer $deadline -- срок изготовления/отправки (не более)
 * @property boolean $request_available - предзапрос при покупке
 * @property integer $buys
 * @property integer $quantity
 * @property Shop $shop
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property MaterialAssign[] $materialAssign
 * @property Material[] $materials
 */
class Product extends BaseProduct
{

    public static function create($name, $name_en, $description, $description_en,
                                  $weight, $size, $article, $collection, $color,
                                  $manufactured_id, $category_id, $cost, $discount,
                                  $deadline, $request_available, $quantity): self
    {
        $product = new static($name, $name_en, $description, $description_en,
            $weight, $size, $article, $collection, $color,
            $manufactured_id, $category_id, $cost, $discount);

        $product->deadline = $deadline;
        $product->request_available = $request_available;
        $product->buys = 0;
        $product->quantity = $quantity;
        return $product;
    }

    public function edit($name, $name_en, $description, $description_en,
                         $weight, $size, $article, $collection, $color,
                         $manufactured_id, $category_id, $cost, $discount,
                         $deadline, $request_available, $quantity): void
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
        $this->quantity = $quantity;

        $this->deadline = $deadline;
        $this->request_available = $request_available;
    }

    public static function tableName()
    {
        return '{{%shops_product}}';
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
        $assign[] = MaterialAssign::create($material);
        $this->materialAssign = $assign;
    }


    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id']);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewProduct::class, ['product_id' => 'id']);
    }

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }

    public function getMaterialAssign(): ActiveQuery
    {
        return $this->hasMany(MaterialAssign::class, ['product_id' => 'id']);
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

}