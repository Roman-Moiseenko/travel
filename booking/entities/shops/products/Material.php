<?php


namespace booking\entities\shops\products;


use yii\db\ActiveRecord;

/**
 * Class Material
 * @package booking\entities\shops\products
 * @property integer $id
 * @property string $name
 */
class Material extends ActiveRecord
{
    public static function create($name): self
    {
        $type = new static();
        $type->name = $name;
    }

    public function edit($name): void
    {
        $this->name = $name;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%shops_product_material}}';
    }
}