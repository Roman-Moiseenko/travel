<?php


namespace booking\repositories\office\guides;


use booking\entities\admin\Contact;
use booking\entities\booking\City;
use booking\entities\booking\stays\duty\Duty;

class DutyRepository
{
    public function get($id): Duty
    {
        if (!$result = Duty::findOne($id)) {
            throw new \DomainException('Сбор не найден');
        }
        return $result;
    }

    public function save(Duty $duty): void
    {
        if (!$duty->save()) {
            throw new \DomainException('Сбор не сохранен');
        }
    }

    public function remove(Duty $duty)
    {
        if (!$duty->delete()) {
            throw new \DomainException('Ошибка удаления сбора');
        }
    }
}