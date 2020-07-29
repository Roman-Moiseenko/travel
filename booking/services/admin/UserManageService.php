<?php


namespace booking\services\admin;

use booking\entities\admin\user\Personal;
use booking\entities\admin\user\User;
use booking\entities\user\FullName;
use booking\entities\user\UserAddress;
use booking\forms\admin\PersonalForm;
use booking\repositories\admin\UserRepository;
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

    public function setPersonal($id, PersonalForm $form)
    {
        $user = $this->users->get($id);
        $personal = $user->personal;
        if ($form->photo->files != null)
            $personal->setPhoto($form->photo->files[0]);
        $personal->phone = $form->phone;
        $personal->dateborn = $form->dateborn;
        $personal->position = $form->position;
        $personal->address =  new UserAddress('ru', $form->address->town, $form->address->address, $form->address->index);
        $personal->fullname = new FullName($form->fullname->surname, $form->fullname->firstname, $form->fullname->secondname);
        $user->updatePersonal($personal);
        //echo '<pre>'; print_r($user->personal); exit();
        $this->users->save($user);
    }

 /*   public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );

       $this->transaction->wrap(function () use($user, $form) {
            $this->users->save($user);
        });
        return $user;
    }*/
/*
    public function update($id, UserEditForm $form): User
    {
        $user = $this->users->get($id);
        $user->edit($form->username, $form->email);
        $this->transaction->wrap(function () use($user, $form) {
            if (!empty($form->password)) $user->setPassword($form->password);
            $this->users->save($user);
        });

        return $user;
    }
    */

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