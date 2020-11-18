<?php

namespace booking\services\check;

use booking\entities\check\User;
use booking\forms\check\UserForm;
use booking\repositories\check\UserRepository;

class UserManageService
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function lock($id)
    {
        $user = $this->users->get($id);
        $user->status = User::STATUS_INACTIVE;
        $this->users->save($user);
    }

    public function unlock($id)
    {
        $user = $this->users->get($id);
        $user->status = User::STATUS_ACTIVE;
        $this->users->save($user);
    }

    public function create($admin_id, UserForm $form): User
    {
        $user = User::create($admin_id, $form->username, $form->password, $form->fullname, $form->box_office, $form->phone);
        $this->users->save($user);
        return $user;
    }

    public function update($user_id, UserForm $form)
    {
        $user = User::findOne($user_id);
        $user->edit($form->username, $form->password, $form->fullname, $form->box_office, $form->phone);
        $this->users->save($user);
    }

    public function addObject($user_id, $object_type, $object_id)
    {
        $user = User::findOne($user_id);
        $user->addObject($object_type, $object_id);
        $this->users->save($user);
    }

    public function removeObject($user_id, $object_type, $object_id)
    {
        $user = User::findOne($user_id);
        $user->removeObject($object_type, $object_id);
        $this->users->save($user);
    }

    public function remove(int $id)
    {
        $user = $this->users->get($id);
        $this->users->remove($user);
    }
}