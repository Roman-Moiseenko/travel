<?php


namespace booking\entities\admin;

use booking\entities\queries\CategoryQuery;
use booking\helpers\SlugHelper;
use paulzi\nestedsets\NestedSetsBehavior;


use yii\db\ActiveRecord;
/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $icon
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Help $parent
 * @property Help[] $parents
 * @property Help[] $children
 * @property Help $prev
 * @property Help $next
 * @mixin NestedSetsBehavior
 */
class Help extends ActiveRecord
{
    public $meta;

    public static function create($title, $slug, $content, $icon): self
    {
        $page = new static();
        $page->title = $title;
        if (empty($slug)) $slug = SlugHelper::slug($title);
        $page->slug = $slug;
        $page->content = $content;
        $page->icon = $icon;
        return $page;
    }

    public function edit($title, $slug, $content, $icon)
    {
        $this->title = $title;
        if (empty($slug)) {
            $slug = SlugHelper::slug($title);
        }
        $this->slug = $slug;
        $this->content = $content;
        $this->icon = $icon;
    }

    public static function tableName()
    {
        return '{{%admin_help}}';
    }
    public function getSeoTitle(): string
    {
        return $this->title;
    }

    public function behaviors()
    {
        return [
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