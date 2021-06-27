<?php


namespace booking\entities\booking;


use yii\db\ActiveRecord;

/**
 * Class TypeMeals
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property string $mark
 * @property string $name
 * @property integer $sort
 */
class Meals extends ActiveRecord
{
    public static function create($mark, $name): self
    {
        $type = new static();
        $type->mark = $mark;
        $type->name = $name;
        return $type;
    }

    public function setSort($id): void
    {
        $this->sort = $id;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function edit($mark, $name): void
    {
        $this->mark = $mark;
        $this->name = $name;
    }

    public static function tableName()
    {
        return '{{%booking_service_meal}}';
    }
}