<?php


namespace booking\repositories\admin;


use booking\entities\admin\user\UserLegal;

class UserLegalRepository
{
    public function get($id): UserLegal
    {
        return UserLegal::findOne($id);
    }

    public function save(UserLegal $legal)
    {
        if (!$legal->save()) {
            throw new \DomainException('Ошибка сохранения организации');
        }
    }
}