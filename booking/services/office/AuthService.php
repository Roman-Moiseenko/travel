<?php


namespace booking\services\office;

use booking\entities\Lang;

use booking\entities\office\User;
use booking\forms\auth\LoginForm;
use booking\repositories\office\UserRepository;


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