<?php


namespace booking\services\office\guides;

use booking\entities\booking\City;
use booking\forms\office\guides\CityForm;
use booking\repositories\office\guides\CityRepository;

class CityService
{

    /**
     * @var CityRepository
     */
    private $cities;

    public function __construct(CityRepository $cities)
    {

        $this->cities = $cities;
    }

    public function create(CityForm $form): City
    {
        $city = City::create($form->name, $form->name_en, $form->latitude, $form->longitude);
        $this->cities->save($city);
        return $city;
    }

    public function edit($id, CityForm $form)
    {
        $city = $this->cities->get($id);
        $city->edit($form->name, $form->name_en, $form->latitude, $form->longitude);
        $this->cities->save($city);
    }
    public function remove($id): void
    {
        $city = $this->cities->get($id);
        $this->cities->remove($city);
    }
}