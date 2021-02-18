<?php

namespace booking\repositories\check;

use booking\entities\check\User;

class UserRepository
{

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByUsernameEmail($value):? User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function getByUsername($username): User
    {
        return $this->getBy(['username' => $username]);
    }


    public function save(User $user): bool
    {
        if (!$user->save()) {
            throw new \DomainException('Ошибка сохранения');
        }
        return true;
    }

    public function remove(User $user)
    {
        if (!$user->delete()) {
            throw new \DomainException('Ошибка удаления');
        }
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::findOne($condition)) {
            throw new \DomainException('Пользователь не найден');
        }
        return $user;
    }
}