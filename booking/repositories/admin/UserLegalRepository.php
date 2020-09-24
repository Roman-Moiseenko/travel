<?php


namespace booking\repositories\admin;


use booking\entities\admin\Legal;

class UserLegalRepository
{
    public function get($id): Legal
    {
        return Legal::findOne($id);
    }

    public function save(Legal $legal)
    {
        if (!$legal->save()) {
            throw new \DomainException('Ошибка сохранения организации');
        }
    }
}