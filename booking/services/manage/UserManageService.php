<?php


namespace booking\services\manage;


use booking\entities\booking\tours\BookingTours;
use booking\entities\booking\tours\Cost;
use booking\entities\user\User;
use booking\forms\booking\tours\BookingToursForm;
use booking\forms\manage\user\UserCreateForm;
use booking\forms\manage\user\UserEditForm;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\UserRepository;
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
    /**
     * @var CostCalendarRepository
     */
    private $calendarsTours;


    public function __construct(UserRepository $users, CostCalendarRepository $calendarsTours, TransactionManager $transaction)
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->calendarsTours = $calendarsTours;
    }

    public function create(UserCreateForm $form): User
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
    }

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
/*
    public function setContact($id, ContactDataForm $form)
    {
        $user = $this->users->get($id);
        $user->editPhone($form->phone);


        $user->editFullName(
            new FullName(
                $this->ExcangeName($form->surname),
                $this->ExcangeName($form->firstname),
                $this->ExcangeName($form->secondname)
            )
        );
        $this->users->save($user);
        return $user;
    }

*/
    public function setCurrency(int $id, $currency)
    {
        $user = $this->users->get($id);
        $user->setCurrency($currency);
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

    public function setLang($id, $lang)
    {
        $user = $this->users->get($id);
        $user->setLang($lang);
        $this->users->save($user);
    }

    public function addBookingTours($id, BookingToursForm $form): BookingTours
    {
        $user = $this->users->get($id);
        $calendar = $this->calendarsTours->get($form->calendar_id);
        $amount = $calendar->cost->adult * $form->count->adult;
        if ($calendar->cost->child && $form->count->child)
            $amount += $calendar->cost->child * $form->count->child;
        if ($calendar->cost->preference && $form->count->preference)
            $amount += $calendar->cost->preference * $form->count->preference;
        //TODO Сделать скидку на $amount
        $user->addBookingTours(
            $amount,
            $form->calendar_id,
            new Cost(
                $form->count->adult,
                $form->count->child,
                $form->count->preference,
            )
        );
        $this->users->save($user);
    }
}