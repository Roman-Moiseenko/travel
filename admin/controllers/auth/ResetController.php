<?php

namespace admin\controllers\auth;

use booking\forms\admin\PasswordResetRequestForm;
use booking\forms\admin\ResendVerificationEmailForm;
use booking\forms\auth\ResetPasswordForm;
use booking\services\admin\PasswordResetService;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class ResetController extends Controller
{
    public  $layout = 'main-login';
    /**
     * @var PasswordResetService
     */

    private  $passwordResetService;

    public function __construct($id, $module, PasswordResetService $passwordResetService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new PasswordResetRequestForm();
        // $service = Yii::$container->get(PasswordResetService::class);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->passwordResetService->request($form);
            try {
                Yii::$app->session->setFlash('success', 'Проверьте вашу почту, ключ отправлен');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', 'Пользователь не найден');
            } catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('error', 'Ошибка отправки почты');
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionReset($token)
    {
        try {
            $this->passwordResetService->validateToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passwordResetService->reset($token, $form);
                Yii::$app->session->setFlash('success', 'Новый пароль сохранен');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('reset', [
            'model' => $form,
        ]);
    }
    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $this->passwordResetService->verifyToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        try {
            $user = $this->passwordResetService->verifyEmail($token);
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Ваша почта подтверждена!');
                return $this->goHome();
            } {
                throw new \DomainException('Ошибка входа в систему');
            }
        } catch (\DomainException $e)
        {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResend()
    {
        $form = new ResendVerificationEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passwordResetService->VerificationEmail($form);
                Yii::$app->session->setFlash('success', 'Проверьте почту, мы Вам выслали инструкцию дальнейших действий');
                return $this->goHome();
            } catch (\RuntimeException $e)
            {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('resend', [
            'model' => $form
        ]);
    }
}