<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\Meals;
use booking\entities\booking\trips\placement\Placement;
use booking\forms\CompositeForm;
use booking\helpers\scr;
use yii\base\Model;

/**
 * Class MealsForm
 * @package booking\forms\booking\trips
 * @property $meals MealAssignForm[]
 */
class MealsForm extends CompositeForm
{
    public $not_meals;


    public function __construct(Placement $placement, $config = [])
    {
        if ($placement->meals) {
            $this->meals = array_map(function (Meals $meal) use ($placement) {
                return new MealAssignForm($meal, $placement->getMealAssignment($meal->id));
            }, Meals::find()->orderBy(['sort' => SORT_ASC])->all());
            $this->not_meals = false;
        } else {
            $this->not_meals = true;
            $this->meals = array_map(function (Meals $meal) {
                return new MealAssignForm($meal);
            }, Meals::find()->orderBy(['sort' => SORT_ASC])->all());
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['not_meals', 'boolean'],
        ];
    }

    public function beforeValidate()
    {
        if ($this->not_meals) {
            $this->meals = [];
        } else {
            $this->meals = array_filter(array_map(function (MealAssignForm $assignForm) { return empty($assignForm->cost) ? false : $assignForm;}, $this->meals));
        }
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    protected function internalForms(): array
    {
        return ['meals'];
    }
}