<?php


namespace booking\entities\shops;


use booking\helpers\SlugHelper;
use yii\db\ActiveRecord;

/**
 * Class TypeShop
 * @package booking\entities\shops
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class TypeShop extends ActiveRecord
{
    public static function create($name): self
    {
        $type = new static();
        $type->name = $name;
        $type->slug = SlugHelper::slug($name);
    }

    public function edit($name): void
    {
        $this->name = $name;
        $this->slug = SlugHelper::slug($name);
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%shops_type}}';
    }
}