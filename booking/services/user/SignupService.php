<?php


namespace booking\services\user;


use booking\entities\Lang;
use booking\entities\user\FullName;
use booking\entities\user\Personal;
use booking\entities\user\User;
use booking\entities\user\UserAddress;
use booking\forms\user\SignupForm;
use booking\helpers\scr;
use booking\repositories\user\UserRepository;
use booking\services\ContactService;
use booking\services\TransactionManager;
use Yii;

class SignupService
{

    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var ContactService
     */
    private $contact;

    public function __construct(
        UserRepository $users,
        TransactionManager $transaction,
        ContactService $contact
    )
    {
        $this->transaction = $transaction;
        $this->users = $users;
        $this->contact = $contact;
    }

    public function signup(SignupForm $form): User
    {

        $user = User::signup($form->username, $form->email, $form->password);
        $user->updatePersonal(Personal::create(
            $form->username,
            null,
            new UserAddress(),
            new FullName(
                $form->surname,
                $form->firstname,
                $form->secondname
            ),
            true,
            ));
        if ($this->users->save($user))
            $this->contact->noticeNewUser($user);
        if (!$this->sendEmail($user)) {
            throw new \DomainException(Lang::t('Ошибка отправки email'));
        }
        return $user;
    }

    private function sendEmail(User $user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'noticeSignup'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Lang::t('Регистрация')])
            ->setTo($user->email)
            ->setSubject(Lang::t('Регистрация на Кёнигс'))
            ->send();
    }
}