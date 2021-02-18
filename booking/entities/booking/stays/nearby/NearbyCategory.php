<?php


namespace booking\entities\booking\stays\nearby;


use yii\db\ActiveRecord;

/**
 * Class NearbyCategory
 * @package booking\entities\booking\stays\nearby
 * @property integer $id
 * @property string $name
 * @property string $group
 * @property integer $sort
 */

class NearbyCategory extends ActiveRecord
{
    public static function create($name, $group): self
    {
        $category = new static();
        $category->name = $name;
        $category->group = $group;
        return $category;
    }

    public function edit($name, $group): void
    {
        $this->name = $name;
        $this->group = $group;
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
        return '{{%booking_stays_nearby_category}}';
    }
}