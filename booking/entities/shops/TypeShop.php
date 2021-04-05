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
    public static function create($name, $slug): self
    {
        $type = new static();
        $type->name = $name;
        $type->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        return $type;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        $this->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
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