<?php


namespace booking\services;


use booking\entities\Lang;
use booking\entities\Rbac;
use booking\entities\user\User;
use booking\helpers\scr;
use booking\repositories\user\UserRepository;

class NetworkService
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var RoleManager
     */
    private $roles;

    public function __construct(UserRepository $users, TransactionManager $transaction, RoleManager $roles)
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->roles = $roles;
    }

    public function auth($network, $identity, $email = null)
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity))
            return $user;
        if ($email && User::find()->where(['email' => $email])->exists())
            throw new \DomainException(Lang::t('Пользователь с таким email уже существует! Зайдите под Вашим логином и привяжите соц.сеть в кабинете'));
        $user = User::signupByNetwork($network, $identity, $email);
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            //$this->roles->assign($user->id, Rbac::ROLE_USER);
        });
        $this->users->save($user);
        return $user;
    }

    public function attach($id, $network, $identity)
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity)) {
            throw new \DomainException('Соцсеть уже подключена к текущему профилю.');
        }
        $user = $this->users->get($id);
        $user->attachNetwork($network, $identity);
        $this->users->save($user);
    }
    public function disconnect($id, $network, $identity)
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity)) {
            $user = $this->users->get($id);
            $user->disconnectNetwork($network, $identity);
            $this->users->save($user);
            return;
        }
        throw new \DomainException('Соцсеть не подключена к текущему профилю.');
    }

}