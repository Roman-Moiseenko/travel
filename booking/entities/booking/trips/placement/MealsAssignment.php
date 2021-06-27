<?php


namespace booking\entities\booking\trips\placement;


use booking\entities\booking\Meals;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Meals
 * @package booking\entities\booking\trips\placement
 * @property integer $placement_id
 * @property string $meal_id
 * @property integer $cost
 * @property Meals $meals
 */

class MealsAssignment extends ActiveRecord
{
    public static function create($meal_id, $cost): self
    {
        $meals = new static();
        $meals->meal_id = $meal_id;
        $meals->cost = $cost;
        return $meals;
    }

    public function edit($meal_id, $cost): void
    {
        $this->meal_id = $meal_id;
        $this->cost = $cost;
    }

    public function isFor($id): bool
    {
        return $this->meal_id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_trips_placement_meals_assign}}';
    }

    public function getMeals(): ActiveQuery
    {
        return $this->hasOne(Meals::class, ['id' => 'meal_id']);
    }
}