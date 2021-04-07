<?php


namespace booking\entities\shops\products;


use booking\entities\Lang;
use yii\db\ActiveRecord;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property integer $id
 * @property integer $shop_id
 * @property string $name
 * @property string $description
 * @property string $name_en
 * @property string $description_en
 * @property integer $created_at
 * @property integer $weight - вес
 * @property string $article - артикул
 * @property string $collection - колекция/серия
 * @property string $color - цвет
 * @property integer $cost - цена
 * @property integer $discount - скидка для текущего товара
 * @property integer $manufactured_id - тип производства
 * @property integer $category_id - категория (вид изделия)
 * @property bool $active
 * @property Size $size - размер
 * @property string $size_json
 * @property boolean $request_available
 */
abstract class BaseProduct extends ActiveRecord
{
    /** @var $size Size */
    public $size;

    public static function create($name, $name_en, $description, $description_en,
                                  $weight, $size, $article, $collection, $color,
                                  $manufactured_id, $category_id, $cost, $discount): self
    {
        $product = new static();
        $product->name = $name;
        $product->name_en = $name_en;
        $product->description = $description;
        $product->description_en = $description_en;

        $product->weight = $weight;
        $product->size = $size;
        $product->article = $article;
        $product->collection = $collection;
        $product->color = $color;

        $product->manufactured_id = $manufactured_id;
        $product->category_id = $category_id;
        $product->cost = $cost;
        $product->discount = $discount;

        $product->active = false;
        $product->created_at = time();

        return $product;
        //Во view при создании проверяетс тип магазина и заполняется $manufactured_id
    }

    public function edit($name, $name_en, $description, $description_en,
                         $weight, $size, $article, $collection, $color,
                         $manufactured_id, $category_id, $cost, $discount): void
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

    final public function active(): void
    {
        $this->active = true;
    }

    final public function draft(): void
    {
        $this->active = false;
    }

    final public function isActive(): bool
    {
        return $this->active;
    }

    final public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    final public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

}