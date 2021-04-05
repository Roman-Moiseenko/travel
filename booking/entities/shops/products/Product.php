<?php


namespace booking\entities\shops\products;


use yii\db\ActiveRecord;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property integer $id
 * @property integer $shop_id
 * @property integer $created_at
 * @property integer $weidth - вес
 * @property string $article - артикул
 * @property string $collection - колекция/серия
 * @property string $color - цвет
 * @property integer $cost - цена
 * @property integer $manufactured_id - тип проихводства
 * @property integer $category_id - категория (вид изделия)
 * @property Size $size - размер
 * @property string $size_json
 * @property boolean $request_available
 */
class Product extends ActiveRecord
{

    public static function create(): self
    {
        //Во view при создании проверяетс тип магазина и заполняется $manufactured_id
    }

    public function getName(): string
    {
        //TODO
    }

    public function getDescription(): string
    {
        //TODO
    }

    public static function tableName()
    {
        return '{{%shops_product}}';
    }
}