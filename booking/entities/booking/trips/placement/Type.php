<?php


namespace booking\entities\booking\trips\placement;


use yii\db\ActiveRecord;

/**
 * Class Type
 * @package booking\entities\booking\trips\placement
 * @property integer $id
 * @property string $name
 */

class Type extends ActiveRecord
{
    public static function create($name): self
    {
        $type = new static();
        $type->name = $name;
        return $type;
    }

    public function edit($name): void
    {
        $this->name = $name;
    }

    public static function tableName()
    {
        return '{{%booking_trips_placement_type}}';
    }
}