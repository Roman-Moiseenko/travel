<?php


namespace booking\services\check;

use booking\entities\check\User;
use booking\forms\auth\LoginForm;
use booking\repositories\check\UserRepository;


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
        $user = $this->users->getByUsername($form->username);
        if (!$user || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль');
        }
        if (!$user->isActive()) {
            throw new \DomainException('Пользователь заблокирован');
        }
        return $user;
    }
}