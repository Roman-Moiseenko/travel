<?php


namespace booking\entities\forum;


use booking\helpers\SlugHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Section
 * @package booking\entities\forum
 * @property integer $id
 * @property string $caption
 * @property string $slug
 * @property integer $sort
 * @property Category[] $categories
 */
class Section extends ActiveRecord
{

    public static function create($caption): self
    {
        $section = new static();
        $section->caption = $caption;
        $section->slug = SlugHelper::slug($caption);
        return $section;
    }

    public function edit($caption, $slug): void
    {
        $this->caption = $caption;
        $this->slug = $slug;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%user_forum_sections}}';
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['section_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }
}