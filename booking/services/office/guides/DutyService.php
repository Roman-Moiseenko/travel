<?php


namespace booking\services\office\guides;

use booking\entities\booking\City;
use booking\entities\booking\stays\duty\Duty;
use booking\forms\office\guides\CityForm;
use booking\forms\office\guides\DutyForm;
use booking\repositories\office\guides\CityRepository;
use booking\repositories\office\guides\DutyRepository;

class DutyService
{

    /**
     * @var DutyRepository
     */
    private $duty;

    public function __construct(DutyRepository $duty)
    {

        $this->duty = $duty;
    }

    public function create(DutyForm $form): Duty
    {
        $city = Duty::create($form->name);
        $this->duty->save($city);
        return $city;
    }

    public function edit($id, DutyForm $form)
    {
        $city = $this->duty->get($id);
        $city->edit($form->name);
        $this->duty->save($city);
    }
    public function remove($id): void
    {
        $city = $this->duty->get($id);
        $this->duty->remove($city);
    }
}