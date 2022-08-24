<?php
declare(strict_types=1);

namespace booking\repositories;

use booking\entities\CheckClickUser;

class CheckClickRepository
{

    public function get($id): CheckClickUser
    {
        if (!$click = CheckClickUser::findOne(['id' => $id])) {
            throw new \DomainException('CheckClick ' . $id . ' не найден.');
        }
        return $click;
    }

    public function save(CheckClickUser $click): void
    {
        if (!$click->save()) {
            throw new \DomainException('Ошибка сохранения CheckClick.');
        }
    }
    public function remove(CheckClickUser $click): void
    {
        if (!$click->delete()) {
            throw new \DomainException('Ошибка удаления CheckClick.');
        }
    }
}