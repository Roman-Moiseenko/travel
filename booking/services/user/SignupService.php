<?php


namespace booking\services\user;


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\user\SignupForm;
use booking\repositories\user\UserRepository;
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
          //  $this->roles->assign($user->id, Rbac::ROLE_USER);
        });

        if (!$this->sendEmail($user)) {
            throw new \RuntimeException(Lang::t('Ошибка отправки email'));
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
            ->setFrom([Yii::$app->params['supportEmail'] => Lang::t('Регистрация kenig.travel')])
            ->setTo($user->email)
            ->setSubject(Lang::t('Account registration at KenigTravel'))
            ->send();
    }
}