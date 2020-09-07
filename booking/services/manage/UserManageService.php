<?php


namespace booking\services\manage;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\entities\user\FullName;
use booking\entities\user\User;
use booking\entities\user\UserAddress;
use booking\forms\admin\PersonalForm;
use booking\forms\booking\tours\BookingToursForm;
use booking\forms\manage\UserCreateForm;
use booking\forms\manage\UserEditForm;
use booking\helpers\scr;
use booking\repositories\booking\tours\BookingTourRepository;
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
    /**
     * @var BookingTourRepository
     */
    private $bookingTours;


    public function __construct(
        UserRepository $users,
        CostCalendarRepository $calendarsTours,
        TransactionManager $transaction,
        BookingTourRepository $bookingTours
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->calendarsTours = $calendarsTours;
        $this->bookingTours = $bookingTours;
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

    public function setPersonal($id, PersonalForm $form)
    {
        $user = $this->users->get($id);
        $personal = $user->personal;
        if ($form->photo->files != null)
            $personal->setPhoto($form->photo->files[0]);
        $personal->phone = $form->phone;
        $personal->dateborn = $form->dateborn;
        $personal->address =  new UserAddress($form->address->country, $form->address->town, $form->address->address, $form->address->index);
        $personal->fullname = new FullName($form->fullname->surname, $form->fullname->firstname, $form->fullname->secondname);
        $user->updatePersonal($personal);
        $this->users->save($user);
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
    //TODO Не используется .......
    public function addBookingTours($id, BookingToursForm $form): BookingTour
    {
        $user = $this->users->get($id);
        $calendar = $this->calendarsTours->get($form->calendar_id);
        $count_booking = $form->count->adult ?? 0 + $form->count->child ?? 0 + $form->count->preference ?? 0;
        if ($calendar->getFreeTickets() < $count_booking) {
            throw new \DomainException(Lang::t('Количество билетов превышает имеющихся в свободном доступе.'));
        }
        $amount = $calendar->cost->adult * $form->count->adult;
        if ($calendar->cost->child && $form->count->child)
            $amount += $calendar->cost->child * $form->count->child;
        if ($calendar->cost->preference && $form->count->preference)
            $amount += $calendar->cost->preference * $form->count->preference;

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

    public function editBookingTours($id, $booking_id, BookingToursForm $form)
    {
        $user = $this->users->get($id);
        $calendar = $this->calendarsTours->get($form->calendar_id);
        $booking = $this->bookingTours->get($booking_id);

        $count_booking = $form->count->adult ?? 0 + $form->count->child ?? 0 + $form->count->preference ?? 0;
        if ($calendar->getFreeTickets() < $count_booking - $booking->countTickets()) {
            throw new \DomainException(Lang::t('Количество билетов превышает имеющихся в свободном доступе.'));
        }
        $amount = $calendar->cost->adult * $form->count->adult;
        if ($calendar->cost->child && $form->count->child)
            $amount += $calendar->cost->child * $form->count->child;
        if ($calendar->cost->preference && $form->count->preference)
            $amount += $calendar->cost->preference * $form->count->preference;
        $user->editBookingTours(
            $booking_id,
            $amount,
            new Cost(
                $form->count->adult,
                $form->count->child,
                $form->count->preference,
            )
        );
        $this->users->save($user);
    }
    
    public function removeBookingTours($id, $booking_id)
    {
        $user = $this->users->get($id);
        $user->cancelBookingTours($booking_id);
        $this->users->save($user);
    }
    public function payBookingTours($id, $booking_id)
    {
        $user = $this->users->get($id);
        $user->payBookingTours($booking_id);
        $this->users->save($user);
    }

    /** ............................................  */

    public function addWishilstTour($id, $tour_id)
    {
        $user = $this->users->get($id);
        $user->addWishlistTour($tour_id);
        $this->users->save($user);
    }

    public function removeWishilstTour($id, $tour_id)
    {
        $user = $this->users->get($id);
        $user->removeWishlistTour($tour_id);
        $this->users->save($user);
    }

    //public function

}