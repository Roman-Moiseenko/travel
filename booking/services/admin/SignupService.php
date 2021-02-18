<?php


namespace booking\services\admin;


use booking\forms\admin\SignupForm;
use booking\entities\admin\User;
use booking\repositories\admin\UserRepository;
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
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
        });
        $this->contact->noticeNewUser($user);
        if (!$this->sendEmail($user)) {
            throw new \DomainException('Ошибка отправки email');
        }
        return $user;
    }

    private function sendEmail(User $user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Регистрация на koenigs.ru'])
            ->setTo($user->email)
            ->setSubject('Аккаунт зарегистрирован на koenigs.ru')
            ->send();
    }
}