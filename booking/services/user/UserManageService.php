<?php


namespace booking\services\user;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\entities\user\FullName;
use booking\entities\user\User;
use booking\entities\user\UserAddress;
use booking\forms\admin\PersonalForm;
use booking\forms\booking\tours\BookingTourForm;
use booking\forms\user\PreferencesForm;
use booking\forms\user\UserCreateForm;
use booking\forms\user\UserEditForm;
use booking\forms\user\UserMailingForm;
use booking\helpers\scr;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\user\UserRepository;
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
      /*  if ($form->agreement == false)
            throw new \DomainException(Lang::t('Вы не подтвердили Согласие'));*/
        $user = $this->users->get($id);
        $personal = $user->personal;
        if ($form->photo->files != null) {
            $personal->setPhoto($form->photo->files[0]);
            $filename = $form->photo->files[0]->tempName;
            $exif = exif_read_data($filename);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation != 1) {
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }
                    if ($deg) {
                        $img = imagerotate($img, $deg, 0);
                    }
                    imagejpeg($img, $filename, 95);
                }
            }
        }
        $personal->edit(
            $form->phone,
            $form->dateborn,
            new UserAddress($form->address->country, $form->address->town, $form->address->address, $form->address->index),
            new FullName($form->fullname->surname, $form->fullname->firstname, $form->fullname->secondname),
            $form->agreement
        );
        /*$personal->phone = $form->phone;
        $personal->dateborn = $form->dateborn;
        $personal->address =  new UserAddress($form->address->country, $form->address->town, $form->address->address, $form->address->index);
        $personal->fullname = new FullName($form->fullname->surname, $form->fullname->firstname, $form->fullname->secondname);*/
        $user->updatePersonal($personal);
        $this->users->save($user);
    }

    public function setPreferences($id, PreferencesForm $form)
    {
        $user = $this->users->get($id);
        $preferences = $user->preferences;
        $mailing = $user->mailing;

        $preferences->lang = $form->lang;
        $preferences->currency = $form->currency;
        $preferences->smocking = $form->smocking;
        $preferences->stars = $form->stars;
        $preferences->disabled = $form->disabled;
        $preferences->notice_dialog = $form->notice_dialog;

        $mailing->new_tours = $form->user_mailing->new_tours;
        $mailing->new_cars = $form->user_mailing->new_cars;
        $mailing->new_stays = $form->user_mailing->new_stays;
        $mailing->new_funs = $form->user_mailing->new_funs;
        $mailing->new_promotions = $form->user_mailing->new_promotions;
        $mailing->news_blog = $form->user_mailing->news_blog;

        $user->updatePreferences($preferences);
        $user->updateMailing($mailing);

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

    /** ............................................  */

    public function addWishlistTour($id, $tour_id)
    {
        $user = $this->users->get($id);
        $user->addWishlistTour($tour_id);
        $this->users->save($user);
    }

    public function removeWishlistTour($id, $tour_id)
    {
        $user = $this->users->get($id);
        $user->removeWishlistTour($tour_id);
        $this->users->save($user);
    }

    public function addWishlistCar($id, $car_id)
    {
        $user = $this->users->get($id);
        $user->addWishlistCar($car_id);
        $this->users->save($user);
    }

    public function removeWishlistCar($id, $car_id)
    {
        $user = $this->users->get($id);
        $user->removeWishlistCar($car_id);
        $this->users->save($user);
    }

    public function addWishlistFun($id, $fun_id)
    {
        $user = $this->users->get($id);
        $user->addWishlistFun($fun_id);
        $this->users->save($user);
    }

    public function removeWishlistFun($id, $fun_id)
    {
        $user = $this->users->get($id);
        $user->removeWishlistFun($fun_id);
        $this->users->save($user);
    }

    public function addWishlistStay($id, $stay_id)
    {
        $user = $this->users->get($id);
        $user->addWishlistStay($stay_id);
        $this->users->save($user);
    }

    public function removeWishlistStay($id, $stay_id)
    {
        $user = $this->users->get($id);
        $user->removeWishlistStay($stay_id);
        $this->users->save($user);
    }
}