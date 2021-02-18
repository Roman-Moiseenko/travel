<?php


namespace booking\services\office;


use booking\entities\office\User;

use booking\repositories\office\UserRepository;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $supportEmail;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct($supportEmail, MailerInterface $mailer, UserRepository $repository)
    {
        $this->supportEmail = $supportEmail;
        $this->mailer = $mailer;
        $this->repository = $repository;
    }

    private function findByEmail($email): User
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $email,
        ]);

        if (!$user) {
            throw new \DomainException('Пользователь не найден');
        }
        return $user;
    }

    public function request(PasswordResetRequestForm $form)
    {
        /* @var $user User */
        $user = $this->repository->getByEmail($form->email);

        $user->requestPasswordReset();

        $this->repository->save($user);

        $sent = $this->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . $user->username)
            ->send();
        if (!$sent) {
            throw new \DomainException('Письмо не отправлено, проверьте правильность заполнения поля Email');
        }
    }

    public function verifyToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        $user = $this->repository->getByEmailConfirmToken($token);
        if ($user->isActive()) {
            throw new \DomainException('Пользователь уже авторизован');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        $this->repository->existsByPasswordResetToken($token);
        /*if (!User::findByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        } */
    }

    public function reset($token, ResetPasswordForm $form): void
    {
        $user = $this->repository->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->repository->save($user, false);
    }

    public function verifyEmail($token): User
    {
        $user = $this->repository->getByEmailConfirmToken($token);

        $user->status = User::STATUS_ACTIVE;
        $user->removeVerificationToken();
        $this->repository->save($user);
        return $user;
    }

    public function VerificationEmail(ResendVerificationEmailForm $form): void
    {
        $user = $this->repository->getByEmail($form->email);

        $send =  $this->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Account registration at ' . $user->username)
            ->send();
        if (!$send) {
            throw new \DomainException('Письмо не отправлено, проверьте правильность заполнения поля Email');
        }
    }

}