<?php


namespace booking\repositories\shops;


use booking\entities\shops\DeliveryCompany;
use booking\entities\shops\products\Material;

class DeliveryCompanyRepository
{
    public function get($id): DeliveryCompany
    {
        if (!$result = DeliveryCompany::findOne($id)) {
            throw new \DomainException('ТК не найдена');
        }
        return $result;
    }

    public function save(DeliveryCompany $company)
    {
        if (!$company->save()) {
            throw new \DomainException('ТК не сохранена');
        }
    }

    public function remove(DeliveryCompany $company)
    {
        if (!$company->delete()) {
            throw new \DomainException('Ошибка удаления ТК');
        }
    }
}