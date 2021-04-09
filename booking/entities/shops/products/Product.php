<?php


namespace booking\entities\shops\products;


use booking\entities\shops\Shop;
use yii\db\ActiveQuery;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property ReviewProduct[] $reviews
 * @property integer $deadline -- срок изготовления/отправки (не более)
 * @property boolean $request_available - предзапрос при покупке
 * @property Shop $shop
 */
class Product extends BaseProduct
{

    public static function create($name, $name_en, $description, $description_en,
                                  $weight, $size, $article, $collection, $color,
                                  $manufactured_id, $category_id, $cost, $discount,
                                  $deadline, $request_available): self
    {
        $product = new static($name, $name_en, $description, $description_en,
            $weight, $size, $article, $collection, $color,
            $manufactured_id, $category_id, $cost, $discount);

        $product->deadline = $deadline;
        $product->request_available = $request_available;
        return $product;
    }
    public function edit($name, $name_en, $description, $description_en,
                         $weight, $size, $article, $collection, $color,
                         $manufactured_id, $category_id, $cost, $discount,
                         $deadline, $request_available): void
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

        $this->deadline = $deadline;
        $this->request_available = $request_available;
    }

    public static function tableName()
    {
        return '{{%shops_product}}';
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
}