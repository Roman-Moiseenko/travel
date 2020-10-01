<?php


namespace booking\entities;


use booking\entities\behaviors\MetaBehavior;
use paulzi\nestedsets\NestedSetsBehavior;

use shop\entities\shop\queries\CategoryQuery;
use shop\forms\manage\MetaForm;
use shop\helpers\SlugHelper;
use yii\db\ActiveRecord;
/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 *
 * @property Page $parent
 * @property Page[] $parents
 * @property Page[] $children
 * @property Page $prev
 * @property Page $next
 * @mixin NestedSetsBehavior
 */
class Page extends ActiveRecord
{
    public $meta;

    public static function create($title, $slug, $content, Meta $meta): self
    {
        $page = new static();
        $page->title = $title;
        if (empty($slug)) $slug = SlugHelper::slug($title);
        $page->slug = $slug;
        $page->content = $content;
        $page->meta = $meta;
        return $page;
    }

    public function edit($title, $slug, $content, Meta $meta)
    {
        $this->title = $title;
        if (empty($slug)) {
            $slug = SlugHelper::slug($title);
        }
        $this->slug = $slug;
        $this->content = $content;
        $this->meta = $meta;
    }

    public static function tableName()
    {
        return '{{%pages}}';
    }
    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
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