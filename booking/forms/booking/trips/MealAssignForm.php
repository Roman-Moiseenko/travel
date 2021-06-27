<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\Meals;
use booking\entities\booking\trips\placement\MealsAssignment;
use yii\base\Model;

class MealAssignForm extends Model
{
    public $cost;
    public $checked;

    /** @var Meals $_meals */
    private $_meals;

    public function __construct(Meals $meals, MealsAssignment $assignment = null, $config = [])
    {
        if ($assignment) {
            $this->cost = $assignment->cost;
        } else {
            $this->cost = null;
        }

        $this->_meals = $meals;
        parent::__construct($config);
    }

    public function mark(): string
    {
        return $this->_meals->mark;
    }

    public function name(): string
    {
        return $this->_meals->name;
    }

    public function id(): int
    {
        return $this->_meals->id;
    }

    public function rules()
    {
        return [
            [['cost'], 'integer'],
        ];
    }
}