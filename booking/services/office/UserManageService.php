<?php


namespace booking\services\office;


use booking\forms\admin\PasswordEditForm;
use booking\repositories\office\UserRepository;
use booking\services\TransactionManager;

class UserManageService
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var TransactionManager
     */
    private $transaction;


    public function __construct(UserRepository $users, TransactionManager $transaction)
    {
        $this->users = $users;
        $this->transaction = $transaction;
    }
/*
    public function setPersonal($id, PersonalForm $form)
    {
        $user = $this->users->get($id);
        $personal = $user->personal;
        if ($form->photo->files != null)
            $personal->setPhoto($form->photo->files[0]);
        $personal->phone = $form->phone;
        $personal->dateborn = $form->dateborn;
        $personal->position = $form->position;
        $personal->address = new UserAddress('RU', $form->address->town, $form->address->address, $form->address->index);
        $personal->fullname = new FullName($form->fullname->surname, $form->fullname->firstname, $form->fullname->secondname);
        $user->updatePersonal($personal);
        $this->users->save($user);
    }



*/
    public function update($id, UserEditForm $form): User
    {
        $user = $this->users->get($id);
        $user->edit($form->username, $form->email);
        $this->transaction->wrap(function () use ($user, $form) {
            if (!empty($form->password)) $user->setPassword($form->password);
            $this->users->save($user);
        });
        return $user;
    }

    public function newPassword(int $id, PasswordEditForm $form)
    {
        $user = $this->users->get($id);
        $user->setPassword($form->password);
        $this->users->save($user);
    }

    private function ExcangeName($name): string
    {
        $name = mb_strtolower($name);
        return mb_strtoupper(mb_substr($name, 0, 1)) . mb_substr($name, 1, mb_strlen($name) - 1);
    }

    public function remove(int $id)
    {
        $user = $this->users->get($id);
        $this->users->remove($user);
    }
}