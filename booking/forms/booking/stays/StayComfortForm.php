<?php


namespace booking\forms\booking\stays;

use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\Stay;
use booking\forms\CompositeForm;
use booking\helpers\scr;

/**
 * Class StayComfortForm
 * @package booking\forms\booking\stays
 * @property AssignComfortForm[] $assignComforts
 */
class StayComfortForm extends CompositeForm
{
    public $stay_id;
    public function __construct(Stay $stay, $config = [])
    {
        $this->stay_id = $stay->id;
        $index = 0;
        $this->assignComforts = array_map(function (Comfort $comfort) use ($stay, &$index) {
            return new AssignComfortForm($comfort, $index++, $stay->getAssignComfort($comfort->id));
        }, Comfort::find()->orderBy('category_id')->all());
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['stay_id', 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['assignComforts'];
    }
}