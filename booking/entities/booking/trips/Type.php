<?php


namespace booking\entities\booking\trips;


use booking\helpers\SlugHelper;

use yii\db\ActiveRecord;

/**
 * Class Type
 * @package booking\entities\booking\trips
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $sort
 */

class Type extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $type = new static();
        $type->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $type->slug = $slug;
        return $type;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
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
        return '{{%booking_trips_type}}';
    }
}