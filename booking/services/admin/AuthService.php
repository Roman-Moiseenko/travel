<?php


namespace booking\services\admin;

use booking\entities\admin\User;
use booking\forms\auth\LoginForm;
use booking\repositories\admin\UserRepository;


class AuthService
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        /** @var User $user */
        $user = $this->users->getByUsernameEmail($form->username);

        if (!$user || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль');
        }
        if ($user->isInactive()) {
            throw new \DomainException('Пользователь не подтвержден');
        }
        if ($user->isLock()) {
            throw new \DomainException('Пользователь заблокирован');
        }

        return $user;
    }
}