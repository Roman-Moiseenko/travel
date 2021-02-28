<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\CustomServices;
use booking\entities\booking\stays\duty\AssignDuty;
use booking\entities\booking\stays\duty\Duty;
use booking\entities\booking\stays\Stay;
use booking\forms\CompositeForm;
use booking\forms\office\guides\DutyForm;
use booking\helpers\scr;

/**
 * Class StayDutyForm
 * @package booking\forms\booking\stays
 * @property CustomServicesForm[] $services
 */
class StayServicesForm extends CompositeForm
{
    public $stay_id;
    public function __construct(Stay $stay, $config = [])
    {
        $this->stay_id = $stay->id;

        $_services = [];
       /* $_services = array_map(function (CustomServices $customService) use ($stay) {
            return new CustomServicesForm($stay->getServicesById($customService->id));
        }, $stay->services);
        $n = count($_services);*/
        for ($i = 0; $i < CustomServices::MAX_SERVICES; $i ++) {
            $_services[] = new CustomServicesForm();
        }
        $this->services = $_services;
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
        return ['services'];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        //Удаление пустых элементов
        $services = $this->services;

       // scr::_p($services);
        foreach ($services as $i => $item) {
            if (empty($item->name) || (int)$item->value == 0 || (int)$item->payment == 0) {
               // scr::_p($item->name);
                unset($services[$i]);
            };
        }
        //scr::_p(count($services));
        //scr::p($services);
        $this->services = $services;
    }
}