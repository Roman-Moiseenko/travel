<?php


namespace booking\forms\foods;


use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Food;
use booking\forms\WorkModeForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use yii\helpers\ArrayHelper;

/**
 * Class FoodForm
 * @package booking\forms\foods
 * @property MetaForm $meta
 * @property WorkModeForm[] $workModes
 */
class FoodForm extends CompositeForm
{
    public $name;
    public $description;
    public $kitchens = [];
    public $categories = [];

    public function __construct(Food $food = null, $config = [])
    {
        if ($food) {
            $this->name = $food->name;
            $this->description = $food->description;

            $this->kitchens = ArrayHelper::getColumn($food->kitchenAssign, 'kitchen_id');
            $this->categories = ArrayHelper::getColumn($food->categoryAssign, 'category_id');
            $this->meta = new MetaForm($food->meta);

            $this->workModes = array_map(function (WorkMode $workMode) {
                return new WorkModeForm($workMode);
            }, $food->workModes);

        } else {
            $_w = [];
            for ($i = 0; $i < 7; $i++) $_w[] = new WorkModeForm();
            $this->workModes = $_w;
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            [['kitchens', 'categories'], 'each', 'rule' => ['integer']],
        ];
    }

    public function beforeValidate(): bool
    {
        $this->kitchens = array_filter((array)$this->kitchens);
        $this->categories = array_filter((array)$this->categories);
        return parent::beforeValidate();
    }

    protected function internalForms(): array
    {
        return ['meta', 'workModes'];
    }
}