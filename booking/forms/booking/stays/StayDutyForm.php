<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\duty\AssignDuty;
use booking\entities\booking\stays\duty\Duty;
use booking\entities\booking\stays\Stay;
use booking\forms\CompositeForm;
use booking\forms\office\guides\DutyForm;
use booking\helpers\scr;

/**
 * Class StayDutyForm
 * @package booking\forms\booking\stays
 * @property AssignDutyForm[] $assignDuty
 */
class StayDutyForm extends CompositeForm
{
    public $stay_id;
    public function __construct(Stay $stay, $config = [])
    {
        $this->stay_id = $stay->id;
        $this->assignDuty = array_map(function (Duty $duty) use ($stay) {
            return new AssignDutyForm($duty, $stay->getDutyById($duty->id));
        }, Duty::find()->all());
        //scr::p($this->assignDuty);
        parent::__construct($config);
    }
    protected function internalForms(): array
    {
        return ['assignDuty'];
    }

    public function afterValidate()
    {
        parent::afterValidate();

    }
}