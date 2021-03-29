<?php


namespace booking\entities\foods;


use booking\helpers\SlugHelper;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package booking\entities\foods
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class Category extends ActiveRecord
{
    public static function create(string $name): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = SlugHelper::slug($name);
        return $category;
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
        return '{{%foods_category}}';
    }
}