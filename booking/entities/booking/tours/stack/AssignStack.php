<?php


namespace booking\entities\booking\tours\stack;


use yii\db\ActiveRecord;

/**
 * Class AssignStack
 * @package booking\entities\booking\tours\stack
 * @property int $tour_id
 * @property int $stack_id
 */
class AssignStack extends ActiveRecord
{

    public static function create($tour_id): self
    {
        $assign = new static();
        $assign->tour_id = $tour_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->tour_id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_tours_stack_assign}}';
    }
}