<?php

namespace booking\services;

use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\ReviewInterface;
use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\helpers\BookingHelper;
use booking\services\pdf\pdfServiceController;
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
                    $this->sendSMS($legal->noticePhone, 'Новое сообщение');
                if ($noticeAdmin->messageNew->email)
                    $this->mailerMessage($legal->noticeEmail, $dialog, 'noticeConversationAdmin', $admin->personal->fullname->getFullname());
            }
        }

        if ($dialog->typeDialog == Dialog::PROVIDER_SUPPORT) {
            $admin = $dialog->admin;
            $noticeAdmin = $admin->notice;
            if ($noticeAdmin->messageNew->phone)
                $this->sendSMS($admin->personal->phone, 'Новое сообщение');
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
        $user = \booking\entities\user\User::findOne(\Yii::$app->user->id);
        $noticeAdmin = $user_admin->notice;
        $legal = $booking->getLegal();
        $phoneUser = $user->personal->phone;
        $phoneAdmin = $legal->noticePhone;
        $emailUser = $user->email;
        $emailAdmin = $legal->noticeEmail;
        //Получаем параметры уведомления
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_NEW) {
            //Новое бронирование  => Рассылка
            //$this->sendSMS($phoneUser, Lang::t('У Вас новое бронирование ') . $booking->getName() . '.' . Lang::t('Не забудьте оплатить'));
            $this->mailerBooking($emailUser, $booking, 'noticeBookingNewUser');

            if ($noticeAdmin->bookingNew->phone)
                $this->sendSMS($phoneAdmin, 'Новое бронирование ' . $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingNew->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingNewAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_PAY) {
            //Бронирование оплачено  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Ваше бронирование подтверждено') . '. ' . $booking->getName() . '. ' . Lang::t('Спасибо, что с нами'));
            $this->mailerBooking($emailUser, $booking, 'noticeBookingPayUser', true);
            if ($noticeAdmin->bookingPay->phone)
                $this->sendSMS($phoneAdmin, 'Подтверждено бронирование ' . $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingPay->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingPayAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL) {
            //Бронирование отменено  => Рассылка
           // $this->sendSMS($phoneUser, Lang::t('Бронирование ') . $booking->getName() . ' ' . Lang::t('отменено'));
            $this->mailerBooking($emailUser, $booking, 'noticeBookingCancelUser');
            if ($noticeAdmin->bookingCancel->phone)
                $this->sendSMS($phoneAdmin, 'Отменено бронирование ' . $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingCancel->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingCancelAdmin');
        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL_PAY) {
            //Бронирование отменено с возвратом денег  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Бронирование ') . $booking->getName() . ' ' . Lang::t('отменено. Оплата поступит в течении 72 часов'));
            $this->mailerBooking($emailUser, $booking, 'noticeBookingCancelPayUser');
            if ($noticeAdmin->bookingCancelPay->phone)
                $this->sendSMS($phoneAdmin, 'Отменено оплаченое бронирование ' . $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingCancelPay->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingCancelPayAdmin');
        }
    }

/// УВЕДОМЛЕНИЕ С КОДОМ ДЛЯ ПОДТВЕРЖДЕНИЯ БРОНИРОВАНИЯ
    public function sendNoticeConfirmation(BookingItemInterface $booking)
    {
        //$confirmation = $booking->getConfirmation();
        $user = \booking\entities\user\User::findOne($booking->getUserId());
        $send = $this->mailer->compose('noticeConfirmation', ['booking' => $booking])
            ->setTo($user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Подтверждение бронирования')])
            ->setSubject($booking->getName())
            ->send();
        if (!$send) {
            throw new \RuntimeException(Lang::t('Ошибка отправки'));
        }
    }

    private function sendSMS($phone, $message)
    {
        if (\Yii::$app->params['NotSend']) return;
        $result = \Yii::$app->sms->send($phone, $message);
        if (!$result)
            throw new \DomainException(Lang::t('Ошибка отправки СМС-сообщения'));
    }

    private function mailerBooking($email, BookingItemInterface $booking, $template, $attach_pdf = false)
    {
        $message = $this->mailer->compose($template, ['booking' => $booking])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Уведомление о Бронировании')])
            ->setSubject($booking->getName() . ' ' . BookingHelper::caption($booking->getStatus()));
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
}