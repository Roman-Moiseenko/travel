<?php


namespace booking\entities\shops\order;


use booking\entities\shops\products\Product;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class OrderItem
 * @package booking\entities\shops\order
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $product_cost ... для истории
 * @property string $product_name  ... для истории
 * @property Product $product
 */

class OrderItem extends ActiveRecord
{

    public static function create(Product $product, $quantity)
    {
        $item = new static();
        $item->product_id = $product->id;
        $item->product_name = $product->name;
        $item->product_cost = $product->cost;
        $item->quantity = $quantity;
        return $item;
    }

    public function getCost(): int
    {
        return $this->product_cost * $this->quantity;
    }

    public static function tableName()
    {
        return '{{%shops_order_item}}';
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function isFor($id)
    {
        return $this->id == $id;
    }
}