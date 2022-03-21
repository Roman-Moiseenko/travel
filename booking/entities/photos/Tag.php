<?php
declare(strict_types=1);

namespace booking\entities\photos;

use booking\helpers\SlugHelper;
use yii\db\ActiveRecord;
/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class Tag extends ActiveRecord
{
    public static function create(string $name, string $slug): self
    {
        $tag = new Tag();
        $tag->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $tag->slug = $slug;
        return $tag;
    }

    public function edit(string $name, string $slug): void
    {
        $this->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $this->slug = $slug;
    }

    public static function tableName()
    {
        return '{{%photos_tags}}';
    }
}