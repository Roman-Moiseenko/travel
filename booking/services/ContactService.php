<?php

namespace booking\services;

use booking\entities\admin\User;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\ReviewInterface;
use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\services\pdf\pdfServiceController;
use booking\sms\sms;
use yii\mail\MailerInterface;

class ContactService
{
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var pdfServiceController
     */
    private $pdf;

    public function __construct(MailerInterface $mailer, pdfServiceController $pdf)
    {
        $this->mailer = $mailer;
        $this->pdf = $pdf;
    }

/// УВЕДОМЛЕНИЕ ПРОВАЙДЕРУ ОБ ОТЗЫВЕ
    public function sendNoticeReview(ReviewInterface $review)
    {
        $user_admin = $review->getAdmin();
        $noticeAdmin = $user_admin->notice;
        $legal = $review->getLegal();
        $phoneAdmin = $legal->noticePhone;
        $emailAdmin = $legal->noticeEmail;
        if ($noticeAdmin->review->phone)
            $this->sendSMS($phoneAdmin, 'Новый отзыв ' . $review->getName());
        if ($noticeAdmin->review->email) {
            $send = $this->mailer->compose('noticeAdminReview', ['review' => $review])
                ->setTo($emailAdmin)
                ->setFrom([\Yii::$app->params['supportEmail'] => 'Новый отзыв'])
                ->setSubject('Новый отзыв')
                ->send();
            if (!$send) {
                throw new \RuntimeException('Ошибка отправки');
            }
        }
    }

/// УВЕДОМЛЕНИЕ КЛИЕНТУ ИЛИ ПРОВАЙДЕРУ О НОВОМ СООБЩЕНИИ
    public function sendNoticeMessage(Dialog $dialog)
    {
        /** @var Conversation $conversation */
        $conversation = $dialog->lastConversation();
        if ($dialog->typeDialog == Dialog::CLIENT_PROVIDER) {
            if (\booking\entities\admin\User::class !== $conversation->author) {
                $admin = $dialog->admin;
                $booking = BookingHelper::getByNumber($dialog->optional);
                $legal = $booking->getLegal();
                $noticeAdmin = $admin->notice;
                if ($noticeAdmin->messageNew->phone)
                    $this->sendSMS($legal->noticePhone, 'Новое сообщение', $admin);
                if ($noticeAdmin->messageNew->email)
                    $this->mailerMessage($legal->noticeEmail, $dialog, 'noticeConversationAdmin', $admin->personal->fullname->getFullname());
            }
        }

        if ($dialog->typeDialog == Dialog::PROVIDER_SUPPORT) {
            $admin = $dialog->admin;
            $noticeAdmin = $admin->notice;
            if ($noticeAdmin->messageNew->phone)
                $this->sendSMS($admin->personal->phone, 'Новое сообщение', $admin);
            if ($noticeAdmin->messageNew->email)
                $this->mailerMessage($admin->email, $dialog, 'noticeConversationAdmin', $admin->personal->fullname->getFullname());
        }

        if ($dialog->typeDialog == Dialog::CLIENT_SUPPORT || $dialog->typeDialog == Dialog::CLIENT_PROVIDER) {
            if (\booking\entities\user\User::class !== $conversation->author) {
                $user = $dialog->user;
                if ($user->preferences->notice_dialog) {
                    $this->mailerMessage($user->email, $dialog, 'noticeConversationUser', $user->personal->fullname->getFullname());
                }
            }
        }
    }

/// УВЕДОМЛЕНИЕ КЛИЕНТУ И ПРОВАЙДЕРУ О БРОНИРОВАНИИ/НОВОМ СТАТУСЕ
    public function sendNoticeBooking(BookingItemInterface $booking)
    {
        $user_admin = $booking->getAdmin();
        $user = \booking\entities\user\User::findOne($booking->getUserId());
        $noticeAdmin = $user_admin->notice;
        $legal = $booking->getLegal();
        $phoneUser = $user->personal->phone;
        $phoneAdmin = $legal->noticePhone;
        $emailUser = $user->email;
        $emailAdmin = $legal->noticeEmail;

        //Получаем параметры уведомления
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_NEW) {
            //Новое бронирование  => Рассылка
            $this->mailerBooking($emailUser, $booking, 'noticeBookingNewUser');

            if ($noticeAdmin->bookingNew->phone)
                $this->sendSMS($phoneAdmin, 'Новое бронирование ' . $booking->getName() . ' на сумму ' . $booking->getAmount(), $user_admin);
            if ($noticeAdmin->bookingNew->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingNewAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_PAY) {
            //Бронирование оплачено  => Рассылка
            if ($noticeAdmin->bookingPayClient->phone)
                $this->sendSMS($phoneUser,
                    Lang::t('Оплачено') . '.' .
                    Lang::t('Бронь') . '#' . BookingHelper::number($booking) . '. ' .
                    Lang::t('ПИН') . '#' . $booking->getPinCode() . '. ' .
                    Lang::t('Спасибо, что Вы с нами'), $user_admin);
            $this->mailerBooking($emailUser, $booking, 'noticeBookingPayUser', true);
            if ($noticeAdmin->bookingPay->phone)
                $this->sendSMS($phoneAdmin, 'Оплачено ' . $booking->getName() . ' (' . $booking->getAmount() . ')', $user_admin);
            if ($noticeAdmin->bookingPay->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingPayAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL) {
            //Бронирование отменено  => Рассылка
            $this->mailerBooking($emailUser, $booking, 'noticeBookingCancelUser');
            if ($noticeAdmin->bookingCancel->phone)
                $this->sendSMS($phoneAdmin, 'Отменено ' . $booking->getName() . ' (' . $booking->getAmount() . ')', $user_admin);
            if ($noticeAdmin->bookingCancel->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingCancelAdmin');
        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL_PAY) {
            $this->mailerBooking($emailUser, $booking, 'noticeBookingCancelPayUser');
            if ($noticeAdmin->bookingCancelPay->phone)
                $this->sendSMS($phoneAdmin, 'Возврат ' . $booking->getName() . ' (' . $booking->getAmount() . ')', $user_admin);
            if ($noticeAdmin->bookingCancelPay->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingCancelPayAdmin');
        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CONFIRMATION) {
            if ($noticeAdmin->bookingConfirmationClient->phone)
                $this->sendSMS($phoneUser,
                    Lang::t('Подтверждено') . '.' .
                    Lang::t('Бронь') . '#' . BookingHelper::number($booking) . '. ' .
                    Lang::t('ПИН') . '#' . $booking->getPinCode() . '. ' .
                    Lang::t('Спасибо, что Вы с нами'), $user_admin);
            $this->mailerBooking($emailUser, $booking, 'noticeBookingConfirmationUser');
            if ($noticeAdmin->bookingConfirmation->phone)
                $this->sendSMS($phoneAdmin, 'Подтверждено ' . $booking->getName() . ' (' . $booking->getAmount() . ')', $user_admin);
            if ($noticeAdmin->bookingConfirmation->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingConfirmationAdmin');
        }
    }

/// УВЕДОМЛЕНИЕ С КОДОМ ДЛЯ ПОДТВЕРЖДЕНИЯ БРОНИРОВАНИЯ
    public function sendNoticeConfirmation(BookingItemInterface $booking, $template = 'pay')
    {
        $user = \booking\entities\user\User::findOne($booking->getUserId());
        $send = $this->mailer->compose('noticeConfirmation-' . $template, ['booking' => $booking])
            ->setTo($user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Подтверждение операции по бронированию')])
            ->setSubject($booking->getName())
            ->send();
        if (!$send) {
            throw new \RuntimeException(Lang::t('Ошибка отправки'));
        }
    }

    private function sendSMS($phone, $message, User $admin_user)
    {
        if (isset(\Yii::$app->params['notSMS']) and \Yii::$app->params['notSMS']) return;
        if (!$admin_user->isSMS()) return;
        if (sms::send($phone, $message)) $admin_user->sendSMS($phone, $message);
    }

    private function mailerBooking($_email, BookingItemInterface $booking, $template, $attach_pdf = false)
    {
        $message = $this->mailer->compose($template, ['booking' => $booking])
            ->setTo((string)$_email)//$email
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Уведомление о Бронировании')])
            ->setSubject($booking->getName() . ' ' . BookingHelper::caption($booking));
        if ($attach_pdf) {
            $file = $this->pdf->pdfFile($booking, true);
            $message = $message->attach($file);
        }
        $send = $message->send();
        if (isset($file)) unlink($file);
        if (!$send) {
            throw new \RuntimeException(Lang::t('Ошибка отправки'));
        }
    }

    private function mailerMessage($email, Dialog $dialog, $template, $user_name = '')
    {
        $send = $this->mailer->compose($template, ['dialog' => $dialog, 'user_name' => $user_name])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Новое сообщение')])
            ->setSubject($dialog->theme->caption)
            ->send();
        if (!$send) {
            throw new \RuntimeException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendLockTour(?\booking\entities\booking\tours\Tour $tour)
    {
        $send = $this->mailer->compose('lockTour', ['tour' => $tour])
            ->setTo($tour->legal->noticeEmail)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Блокировка')])
            ->setSubject($tour->name)
            ->send();
        if (!$send) {
            throw new \RuntimeException(Lang::t('Ошибка отправки'));
        }
    }

    public function noticeNewUser($user)
    {
        if ($user instanceof User) {
            $subject = 'Новый Провайдер';
        } else {
            $subject = 'Новый Клиент';
        }
        $send = $this->mailer->compose('signupUser', ['user' => $user])
            ->setTo(\Yii::$app->params['signupEmail'])
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Новый пользователь'])
            ->setSubject($subject)
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }
}