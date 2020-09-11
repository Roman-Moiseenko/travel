<?php


namespace booking\services\admin;

use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\Discount;
use booking\entities\user\FullName;
use booking\entities\user\UserAddress;
use booking\forms\admin\ContactAssignmentForm;
use booking\forms\admin\NoticeForm;
use booking\forms\admin\PasswordEditForm;
use booking\forms\admin\PersonalForm;
use booking\forms\admin\UserEditForm;
use booking\forms\admin\UserLegalForm;
use booking\forms\booking\DiscountForm;
use booking\helpers\scr;
use booking\repositories\admin\UserRepository;
use booking\services\booking\DiscountService;
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
        $personal->address = new UserAddress('RU', $form->address->town, $form->address->address, $form->address->index);
        $personal->fullname = new FullName($form->fullname->surname, $form->fullname->firstname, $form->fullname->secondname);
        $user->updatePersonal($personal);
        $this->users->save($user);
    }

    /** Не используется */
    public function setNotice($id, NoticeForm $form)
    {
        $user = $this->users->get($id);
        $notice = $user->notice;
        $notice->review = $form->review;
        $notice->bookingNew = $form->bookingNew;
        $notice->bookingPay = $form->bookingPay;
        $notice->bookingCancel = $form->bookingCancel;
        $notice->bookingCancelPay = $form->bookingCancelPay;
        $notice->messageNew = $form->messageNew;
        $user->updateNotice($notice);
        $this->users->save($user);
    }

    public function newLegal($id, UserLegalForm $form): UserLegal
    {
        $user = $this->users->get($id);
        $legal = UserLegal::create(
            $form->name,
            $form->BIK,
            $form->account,
            $form->INN,
            $form->caption,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->office,
            $form->noticePhone,
            $form->noticeEmail,
            $form->OGRN,
            $form->KPP
        );
        if ($form->photo->files != null)
            $legal->setPhoto($form->photo->files[0]);
        $user->addLegal($legal);
        $this->users->save($user);
        return $legal;
    }

    public function editLegal($user_id, $legal_id, UserLegalForm $form)
    {
        $user = $this->users->get($user_id);
        $legal = $user->getLegal($legal_id);
        $legal->edit(
            $form->name,
            $form->BIK,
            $form->account,
            $form->INN,
            $form->caption,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->office,
            $form->noticePhone,
            $form->noticeEmail,
            $form->OGRN,
            $form->KPP
        );

        if ($form->photo->files != null)
            $legal->setPhoto($form->photo->files[0]);
        $user->updateLegal($legal_id, $legal);
        $this->users->save($user);
    }

    public function removeLegal($user_id, $legal_id)
    {
        $user = $this->users->get($user_id);
        $user->removeLegal($legal_id);
        $this->users->save($user);
    }

    public function addLegalContact($legal_id, ContactAssignmentForm $form)
    {
        $user = $this->users->get($legal_id);
        $legal = $user->getLegal($legal_id);
        $legal->addContact(
            $form->contact_id,
            $form->value,
            $form->description,
            $form->link
        );
        $this->users->save($user);
    }

    public function updateLegalContact($legal_id, $contact_id, ContactAssignmentForm $form)
    {
        $user = $this->users->get($legal_id);
        $legal = $user->getLegal($legal_id);
        $legal->updateContact(
            $contact_id,
            $form->value,
            $form->description,
            $form->link
        );
        $this->users->save($user);
    }

    public function removeLegalContact($legal_id, $contact_id)
    {
        $user = $this->users->get($legal_id);
        $legals = $user->legals;
        foreach ($legals as $legal) {
            if ($legal->isFor($legal_id)) {
                $legal->removeContact($contact_id);
            }
        }
        $this->users->save($user);
    }

    public function addDiscount($user_id, DiscountForm $form): Discount
    {
        $user = $this->users->get($user_id);
        ini_set('max_execution_time', $form->repeat * 2);
        for ($i = 1; $i <= $form->repeat; $i++) {
            $discount = Discount::create(
                $form->entities,
                $form->entities_id == 0 ? null : $form->entities_id,
                DiscountService::generatePromo($form->entities),
                $form->percent,
                $form->count
            );
            $user->addDiscount($discount);
            sleep(1);
        }
        $this->users->save($user);
        ini_set('max_execution_time', 30);
        return $discount;
    }

    public function draftDiscount($user_id, $discount_id): void
    {
        $user = $this->users->get($user_id);
        $user->draftDiscount($discount_id);
        $this->users->save($user);
    }

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