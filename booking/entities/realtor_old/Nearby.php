<?php


namespace booking\entities\realtor_old;


use yii\db\ActiveRecord;

/**
 * Class NearbyCategory
 * @package booking\entities\realtor
 * @property integer $id
 * @property string $name
 * @property integer $sort
 */

class Nearby extends ActiveRecord
{
    public static function create($name): self
    {
        $category = new static();
        $category->name = $name;
        return $category;
    }

    public function edit($name): void
    {
        $this->name = $name;
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
        return '{{%realtor_nearby}}';
    }

}