<?php


namespace booking\services\admin;


use booking\forms\auth\SignupForm;
use booking\entities\admin\user\User;
use booking\repositories\admin\UserRepository;
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

    public function __construct(
        UserRepository $users,
        TransactionManager $transaction
    )
    {
        $this->transaction = $transaction;
        $this->users = $users;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::signup($form->username, $form->email, $form->password);
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
        });

        if (!$this->sendEmail($user)) {
            throw new \RuntimeException('Ошибка отправки email');
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
            ->setFrom([Yii::$app->params['supportEmail'] => 'Регистрация kenig.travel'])
            ->setTo($user->email)
            ->setSubject('Account registration at KenigTravel')
            ->send();
    }
}