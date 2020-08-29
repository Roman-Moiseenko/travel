<?php

namespace booking\repositories\admin;

use booking\entities\admin\user\User;
use booking\entities\Lang;

class UserRepository
{

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['verification_token' => $token]);
    }

    public function getByEmail($email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function getByUsernameEmail($value):? User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function getByUsername($username): User
    {
        return $this->getBy(['username' => $username]);
    }
    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException(Lang::t('Ошибка сохранения'));
        }
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::findOne($condition)) {
            throw new \DomainException(Lang::t('Пользователь не найден'));
        }
        return $user;
    }

    public function remove(User $user)
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Ошибка удаления');
        }
    }

}