<?php


namespace booking\entities\art\event;


use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package booking\entities\art\event
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property integer $sort
 * @property string $meta_json [json]
 */
class Category extends ActiveRecord
{
    /** @var $meta Meta */
    public $meta;

    public static function create($name, $slug, $icon): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $category->icon = $icon;
        return $category;
    }

    public function edit($name, $slug, $icon)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->icon = $icon;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%art_event_category}}';
    }
    public function behaviors()
    {
        return [
            MetaBehavior::class,
        ];
    }
}