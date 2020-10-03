<?php


namespace booking\entities\blog;

use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use yii\db\ActiveRecord;
/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $sort
 * @property Meta $meta

 */
class Category extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, $title, $description, $sort, Meta $meta): self
    {
        $category = new static();
        $category->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
        $category->sort = $sort;
        return $category;
    }

    public function edit($name, $slug, $title, $description, $sort, Meta $meta)
    {
        $this->name = $name;
        if (empty($slug)) {
            $slug = SlugHelper::slug($name);
        }
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;
        $this->sort = $sort;

    }

    public static function tableName()
    {
        return '{{%blog_categories}}';
    }
    public function getSeoTitle(): string
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
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }


}