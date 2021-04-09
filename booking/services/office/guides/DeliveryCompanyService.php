<?php


namespace booking\services\office\guides;

use booking\entities\booking\City;
use booking\entities\shops\DeliveryCompany;
use booking\forms\office\guides\CityForm;
use booking\forms\office\guides\DeliveryCompanyForm;
use booking\repositories\office\guides\CityRepository;
use booking\repositories\shops\DeliveryCompanyRepository;

class DeliveryCompanyService
{

    /**
     * @var CityRepository
     */
    private $companies;

    public function __construct(DeliveryCompanyRepository $companies)
    {
        $this->companies = $companies;
    }

    public function create(DeliveryCompanyForm $form): DeliveryCompany
    {
        $company = DeliveryCompany::create($form->name, $form->link);
        $company->api($form->api_json);
        $this->companies->save($company);
        return $company;
    }

    public function edit($id, DeliveryCompanyForm $form)
    {
        $company = $this->companies->get($id);
        $company->edit($form->name, $form->link);
        $company->api($form->api_json);
        $this->companies->save($company);
    }
    public function remove($id): void
    {
        $company = $this->companies->get($id);
        $this->companies->remove($company);
    }
}