<?php


namespace booking\entities\blog;

use booking\entities\behaviors\MetaBehavior;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use yii\db\ActiveRecord;
/**
 * @property integer $id
 * @property string $name
 * @property string $name_en
 * @property string $slug
 * @property string $title
 * @property string $title_en
 * @property string $description
 * @property string $description_en
 * @property integer $sort
 * @property Meta $meta
 * @property string $meta_json [json]
 */
class Category extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, $title, $description, $sort, Meta $meta, $name_en, $title_en, $description_en): self
    {
        $category = new static();
        $category->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
        $category->sort = $sort;

        $category->name_en = $name_en;
        $category->title_en = $title_en;
        $category->description_en = $description_en;
        return $category;
    }

    public function edit($name, $slug, $title, $description, $sort, Meta $meta, $name_en, $title_en, $description_en)
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

        $this->name_en = $name_en;
        $this->title_en = $title_en;
        $this->description_en = $description_en;
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
        return $this->getTitle() ?: $this->getName();
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

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public function getTitle()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->title_en)) ? $this->title : $this->title_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }
}