<?php


namespace booking\services;


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\auth\LoginForm;
use booking\repositories\UserRepository;

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
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException(Lang::t('Неверный логин или пароль'));
        }
        return $user;
    }
}