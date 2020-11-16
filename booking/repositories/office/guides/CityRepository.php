<?php


namespace booking\repositories\office\guides;


use booking\entities\admin\Contact;
use booking\entities\booking\City;

class CityRepository
{
    public function get($id): City
    {
        if (!$result = City::findOne($id)) {
            throw new \DomainException('Город не найден');
        }
        return $result;
    }

    public function save(City $city): void
    {
        if (!$city->save()) {
            throw new \RuntimeException('Город не сохранен');
        }
    }

    public function remove(City $city)
    {
        if (!$city->delete()) {
            throw new \RuntimeException('Ошибка удаления города');
        }
    }
}