<?php


namespace booking\entities\shops\products;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\entities\queries\CategoryQuery;
use booking\helpers\SlugHelper;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 * @property string $meta_json [json]
 * @mixin NestedSetsBehavior
 */

class Category extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, $title, $description, Meta $meta): self
    {
        $category = new static();
        $category->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $slug, $title, $description, Meta $meta)
    {
        $this->name = $name;
        if (empty($slug)) {
            $slug = SlugHelper::slug($name);
        }
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;
    }

    public static function tableName()
    {
        return '{{%shops_product_category}}';
    }

    public function getSeoTile(): string
    {
        return $this->meta->title ?: $this->getHeadingTile();
    }

    public function getHeadingTile(): string
    {
        return $this->title ?: $this->name;
    }
    public function behaviors()
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }
}