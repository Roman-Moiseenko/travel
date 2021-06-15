<?php


namespace booking\entities\booking\tours\services;


use yii\db\ActiveRecord;

/**
 * Class Capacity
 * @package booking\entities\booking\tours\services
 * @property integer $id
 * @property integer $user_id
 * @property integer $count
 * @property integer $percent
 */

class Capacity extends ActiveRecord
{

    public static function create($count, $percent): self
    {
        $capacity = new static();
        $capacity->count = $count;
        $capacity->percent = $percent;
        return $capacity;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%users_tour_capacity}}';
    }
}