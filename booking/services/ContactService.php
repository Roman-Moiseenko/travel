<?php

namespace booking\services;

use booking\entities\admin\User;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\ReviewInterface;
use booking\entities\Lang;
use booking\entities\mailing\Mailing;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\helpers\BookingHelper;
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
    private $loc;

    public function __construct(
        MailerInterface $mailer,
        pdfServiceController $pdf
    )
    {
        $this->mailer = $mailer;
        $this->pdf = $pdf;
        $this->loc = \Yii::$app->params['local'] ?? false;
    }

/// УВЕДОМЛЕНИЕ ПРОВАЙДЕРУ ОБ ОТЗЫВЕ
    public function sendNoticeReview(ReviewInterface $review)
    {
        if ($this->loc) return;
        $user_admin = $review->getAdmin();
        $noticeAdmin = $user_admin->notice;
        $legal = $review->getLegal();
        $emailAdmin = $legal->noticeEmail;
        if ($noticeAdmin->review->email) {
            $send = $this->mailer->compose('noticeAdminReview', ['review' => $review])
                ->setTo($emailAdmin)
                ->setFrom([\Yii::$app->params['supportEmail'] => 'Новый отзыв'])
                ->setSubject('Новый отзыв')
                ->send();
            if (!$send) {
                throw new \DomainException('Ошибка отправки');
            }
        }
    }

/// УВЕДОМЛЕНИЕ КЛИЕНТУ ИЛИ ПРОВАЙДЕРУ О НОВОМ СООБЩЕНИИ
    public function sendNoticeMessage(Dialog $dialog)
    {
        if ($this->loc) return;
        /** @var Conversation $conversation */
        $conversation = $dialog->lastConversation();
        if ($dialog->typeDialog == Dialog::CLIENT_PROVIDER) {
            if (\booking\entities\admin\User::class !== $conversation->author) {
                $admin = $dialog->admin;
                $booking = BookingHelper::getByNumber($dialog->optional);
                $legal = $booking->getLegal();
                $noticeAdmin = $admin->notice;
                if ($noticeAdmin->messageNew->email)
                    $this->mailerMessage($legal->noticeEmail, $dialog, 'noticeConversationAdmin', $admin->personal->fullname->getFullname());
            }
        }

        if ($dialog->typeDialog == Dialog::PROVIDER_SUPPORT) {
            $admin = $dialog->admin;
            $noticeAdmin = $admin->notice;
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
        if ($this->loc) return;
        $user_admin = $booking->getAdmin();
        $user = \booking\entities\user\User::findOne($booking->getUserId());
        $noticeAdmin = $user_admin->notice;
        $legal = $booking->getLegal();
        $phoneUser = $user->personal->phone;
        $phoneAdmin = $legal->noticePhone;
        $emailUser = $user->email;
        $emailAdmin = $legal->noticeEmail;
        $emailPayment = \Yii::$app->params['payEmail'];
        //Получаем параметры уведомления
        if ($booking->isNew()) {  //Новое бронирование  => Рассылка
            $this->mailerBooking($emailUser, $booking, 'noticeBookingNewUser');
            if ($noticeAdmin->bookingNew->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingNewAdmin');
        }

        if ($booking->isPay()) {//Бронирование оплачено  => Рассылка  //$booking->isCheckBooking() - лишняя проверка
            //При оплате через сайт всегда клиенту отправлять СМС
            if ($phoneUser) {  //Если пользователь ввел телефон
                $this->sendSMS($phoneUser,
                    Lang::t('Оплачено') . '.' .
                    Lang::t('Бронь') . '#' . BookingHelper::number($booking) . '. ' .
                    Lang::t('ПИН') . '#' . $booking->getPinCode() . '. ' .
                    Lang::t('Для уточнений свяжитесь по т. ') . $phoneAdmin, $user_admin);
                $this->mailerBooking($emailUser, $booking, 'noticeBookingPayUser', true);
            }

            if ($noticeAdmin->bookingPay->phone) { //Если провайдер хочет получить СМС
                $this->sendSMS($phoneAdmin, 'Бронь ' . $booking->getName() . ' ' . date('d-m', $booking->getDate()) . ' ' . $booking->getAdd(), $user_admin);
            }
            if ($noticeAdmin->bookingPay->email) //Если провайдер хочет получить Email
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingPayAdmin');
            //отправить данные об оплате агрегатору
            $this->mailerBooking($emailPayment, $booking, 'noticeBookingPayOffice');
        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL) {
            //Бронирование отменено  => Рассылка
            $this->mailerBooking($emailUser, $booking, 'noticeBookingCancelUser');
            if ($noticeAdmin->bookingCancel->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingCancelAdmin');
        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL_PAY) {
            $this->mailerBooking($emailUser, $booking, 'noticeBookingCancelPayUser');
            $this->sendSMS($phoneUser, 'Отмена брони ' . $booking->getName(), $user_admin);
            if ($booking->isCheckBooking() && $noticeAdmin->bookingCancelPay->phone)
                $this->sendSMS($phoneAdmin, 'Возврат ' . $booking->getName() . ' (' . $booking->getAmount() . ')', $user_admin);
            if ($noticeAdmin->bookingCancelPay->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingCancelPayAdmin');
        }
        if ($booking->isConfirmation()) {
            $this->mailerBooking($emailUser, $booking, 'noticeBookingConfirmationUser');
            if ($noticeAdmin->bookingConfirmation->email)
                $this->mailerBooking($emailAdmin, $booking, 'noticeBookingConfirmationAdmin');
        }
    }

/// УВЕДОМЛЕНИЕ С КОДОМ ДЛЯ ПОДТВЕРЖДЕНИЯ БРОНИРОВАНИЯ
    public function sendNoticeConfirmation(BookingItemInterface $booking, $template = 'pay')
    {
        if ($this->loc) return;
        $user = \booking\entities\user\User::findOne($booking->getUserId());
        $send = $this->mailer->compose('noticeConfirmation-' . $template, ['booking' => $booking])
            ->setTo($user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Подтверждение операции по бронированию')])
            ->setSubject($booking->getName())
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendLockTour(?\booking\entities\booking\tours\Tour $tour)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('lockTour', ['tour' => $tour])
            ->setTo($tour->legal->noticeEmail)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Блокировка')])
            ->setSubject($tour->name)
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendLockFun(?\booking\entities\booking\funs\Fun $fun)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('lockFun', ['fun' => $fun])
            ->setTo($fun->legal->noticeEmail)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Блокировка')])
            ->setSubject($fun->name)
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function noticeNewUser($user)
    {
        if ($this->loc) return;
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
            throw new \DomainException('Ошибка отправки');
        }
    }

    public function sendMailing(Mailing $mailing, array $emails)
    {
        if ($this->loc) return;
        $messages = [];
        foreach ($emails as $email) {
            $messages[] = $this->mailer->compose('Mailing', ['subject' => $mailing->subject, 'email' => $email])
                ->setTo($email)
                ->setFrom([\Yii::$app->params['supportEmail'] => 'Рассылка от koenigs.ru'])
                ->setSubject(Mailing::nameTheme($mailing->theme));
        }
        $send = $this->mailer->sendMultiple($messages);
        if (!$send) {
            throw new \DomainException('Ошибка отправки');
        }
        return true;
    }

    public function sendLockCar(?\booking\entities\booking\cars\Car $car)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('lockCar', ['car' => $car])
            ->setTo($car->legal->noticeEmail)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Блокировка')])
            ->setSubject($car->name)
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendActivate($object, $username)
    {
        if ($this->loc) return;
        /** Уведомление Главного по Активации */
        //почта
        $send = $this->mailer->compose('Activated', ['object' => $object, 'username' => $username])
            ->setTo(\Yii::$app->params['providerEmail'])
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Активация объекта'])
            ->setSubject($object)
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
        //СМС
        if (\Yii::$app->params['SMSActivated'])
            $this->sendSMS(\Yii::$app->params['SMSActivated'], 'New Activated!', User::findOne(\Yii::$app->user->id));
    }

    public function sendCancelProvider(\booking\entities\booking\tours\BookingTour $booking)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('Activated', ['object' => $object, 'username' => $username])
            ->setTo(\Yii::$app->params['providerEmail'])
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Активация объекта'])
            ->setSubject($object)
            ->send();
    }

    private function sendSMS($phone, $message, User $admin_user = null)
    {
        if (isset(\Yii::$app->params['notSMS']) and \Yii::$app->params['notSMS'] == true) return;
        if (sms::send($phone, $message))
            if ($admin_user) $admin_user->sendSMS($phone, $message);
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
            throw new \DomainException(Lang::t('Ошибка отправки'));
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
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendLockStay(?\booking\entities\booking\stays\Stay $stay)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('lockStay', ['stay' => $stay])
            ->setTo($stay->legal->noticeEmail)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Блокировка')])
            ->setSubject($stay->name)
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }
}