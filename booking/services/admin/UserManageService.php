<?php


namespace booking\services\admin;

use booking\entities\admin\Debiting;
use booking\entities\admin\Deposit;
use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\BookingAddress;
use booking\entities\user\FullName;
use booking\entities\user\UserAddress;
use booking\forms\admin\CertForm;
use booking\forms\admin\ContactAssignmentForm;
use booking\forms\admin\NoticeForm;
use booking\forms\admin\PasswordEditForm;
use booking\forms\admin\PersonalForm;
use booking\forms\admin\UserEditForm;
use booking\forms\admin\UserLegalForm;
use booking\helpers\scr;
use booking\helpers\SysHelper;
use booking\repositories\admin\UserLegalRepository;
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
    /**
     * @var UserLegalRepository
     */
    private $legals;

    public function __construct(UserRepository $users, TransactionManager $transaction, UserLegalRepository $legals)
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->legals = $legals;
    }

    //************* Balance ***************

    public function addDeposit($id, $amount, $payment_id): void
    {
        $user = $this->users->get($id);
        $user->newDeposit(Deposit::create($amount, $payment_id));
        $this->users->save($user);
    }

    public function addDebiting($id, $amount, $type, $caption, $link): void
    {
        $user = $this->users->get($id);
        $user->newDebiting(Debiting::create($amount, $type, $caption, $link));
        $this->users->save($user);
    }

    public function lock($id)
    {
        $user = $this->users->get($id);
        $user->status = User::STATUS_LOCK;
        $this->users->save($user);
    }

    public function unlock($id)
    {
        $user = $this->users->get($id);
        $user->status = User::STATUS_ACTIVE;
        $this->users->save($user);
    }

    public function setPersonal($id, PersonalForm $form)
    {
        $user = $this->users->get($id);
        $personal = $user->personal;
        if ($form->photo->files != null) {
            $personal->setPhoto($form->photo->files[0]);
            SysHelper::orientation($form->photo->files[0]->tempName);
        }
        $personal->edit(
            $form->phone,
            $form->dateborn,
            new UserAddress($form->address->country, $form->address->town, $form->address->address, $form->address->index),
            new FullName($form->fullname->surname, $form->fullname->firstname, $form->fullname->secondname),
            $personal->position = $form->position,
            $form->agreement
        );

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

    public function newLegal($id, UserLegalForm $form): Legal
    {
        $user = $this->users->get($id);
        $legal = Legal::create(
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
            $form->KPP,
            $form->caption_en,
            $form->description_en
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
        //throw new \DomainException('test');
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
            $form->KPP,
            $form->caption_en,
            $form->description_en
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

    /**==> Legal RelationShip
     *
     * @param $legal_id
     * @param ContactAssignmentForm $form
     */

    public function addLegalContact($legal_id, ContactAssignmentForm $form)
    {
        $legal = $this->legals->get($legal_id);
        $legal->addContact(
            $form->contact_id,
            $form->value,
            $form->description
        );
        $this->legals->save($legal);
    }

    public function updateLegalContact($legal_id, $contact_id, ContactAssignmentForm $form)
    {
        $legal = $this->legals->get($legal_id);
        $legal->updateContact(
            $contact_id,
            $form->value,
            $form->description
        );
        $this->legals->save($legal);
    }

    public function removeLegalContact($legal_id, $contact_id)
    {
        $legal = $this->legals->get($legal_id);
        $legal->removeContact($contact_id);
        $this->legals->save($legal);
    }

    public function addLegalCert($legal_id, CertForm $form)
    {

        if ($form->file->files == null) {
            throw new \DomainException('Загрузите скан документа');
        }
        $legal = $this->legals->get($legal_id);
        $legal->addCert(
            $form->file->files[0],
            $form->name,
            $form->issue_at
        );
        $this->legals->save($legal);
    }

    public function updateLegalCert($legal_id, $cert_id, CertForm $form)
    {
        $legal = $this->legals->get($legal_id);
        $legal->updateCert(
            $cert_id,
            $form->file,
            $form->name,
            $form->issue_at
        );
        $this->legals->save($legal);
    }

    public function removeLegalCert($legal_id, $cert_id)
    {
        $legal = $this->legals->get($legal_id);
        $legal->removeCert($cert_id);
        $this->legals->save($legal);
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

    public function setForumRole(int $id, int $role)
    {
        $user = $this->users->get($id);
        $user->setForumRole($role);
        $this->users->save($user);
    }

    public function ConfirmationToUpDeposit(string $id)
    {
        $deposit = Deposit::findOne(['payment_id' => $id]);
        $deposit->setPay();
        $deposit->save();
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