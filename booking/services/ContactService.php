<?php

namespace booking\services;

use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\BaseObjectOfBooking;
use booking\entities\booking\BaseReview;
use booking\entities\Lang;
use booking\entities\mailing\Mailing;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\entities\moving\FAQ;
use booking\entities\shops\order\Order;
use booking\entities\shops\Shop;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\services\pdf\pdfServiceController;
use booking\services\system\LoginService;
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
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        MailerInterface $mailer,
        pdfServiceController $pdf,
        LoginService $loginService
    )
    {
        $this->mailer = $mailer;
        $this->pdf = $pdf;
        $this->loc = \Yii::$app->params['local'] ?? false;
        $this->loginService = $loginService;
    }

/// УВЕДОМЛЕНИЕ ПРОВАЙДЕРУ ОБ ОТЗЫВЕ
    public function sendNoticeReview(BaseReview $review)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('noticeReview', ['review' => $review])
            ->setTo(\Yii::$app->params['reviewEmail'])
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Новый отзыв'])
            ->setSubject('Новый отзыв')
            ->send();
        if (!$send) {
            throw new \DomainException('Ошибка отправки');
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
    public function sendNoticeBooking(BaseBooking $booking) //BookingItemInterface
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
            if (!$booking->isPaidLocally() && $noticeAdmin->bookingCancelPay->phone)
                $this->sendSMS($phoneAdmin, 'Возврат ' . $booking->getName() . ' (' . $booking->getPayment()->getPrepay() . ')', $user_admin);
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
    public function sendNoticeConfirmation(BaseBooking $booking, $template = 'pay')//BookingItemInterface
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

    public function sendOrder(Order $order)
    {
        $admin_email = $order->shop->legal->noticeEmail;
        $user_email = $order->user->email;
        if ($order->isNew()) {
            $subject = 'Новый Заказ #' . $order->number;
            $email = $admin_email;
        }

        if ($order->isConfirmation()) {
            $subject = 'Заказ подтвержден #' . $order->number;
            $email = $user_email;
        }

        if ($order->isCanceled()) {
            $subject = 'Заказ отменен #' . $order->number;
            $email = $user_email;
        }

        if ($order->isPaid()) {
            $subject = 'Заказ оплачен #' . $order->number;
            $email = $admin_email;
        }

        if ($order->isSent()) {
            $subject = 'Заказ отправлен #' . $order->number;
            $email = $user_email;
        }

        if ($order->isCompleted()) {
            $subject = 'Заказ завершен #' . $order->number;
            $email = $user_email;
        }
        if (isset($email) && isset($subject)) {
            $send = $this->mailer->compose('noticeOrder', ['order' => $order])
                ->setTo($email)
                ->setFrom([\Yii::$app->params['supportEmail'] => 'Онлайн Заказ в Koenigs.RU'])
                ->setSubject($subject)
                ->send();
            if (!$send) {
                throw new \DomainException('Ошибка отправки');
            }
        } else {
            throw new \DomainException('Неверный статус Заказа для отправки');
        }
    }

/// РАССЫЛКИ
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

/// УВЕДОМЛЕНИЯ ОФИСА
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
            $this->sendSMS(\Yii::$app->params['SMSActivated'], 'New Activated!', $this->loginService->admin());
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

/// УВЕДОМЛЕНИЯ О БЛОКИРОВКЕ ОБЪЕКТОВ

    public function sendLockShop(Shop $shop) //Не бронируемый тип
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('lockShop', ['shop' => $shop])
            ->setTo($shop->user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Блокировка')])
            ->setSubject($shop->name)
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendLock(BaseObjectOfBooking $object) //Бронируемый тип
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('lockObject', ['object' => $object])
            ->setTo($object->user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Блокировка')])
            ->setSubject($object->getName())
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

/// ВНУТРЕННИЕ ФУНКЦИИ
    private function sendSMS($phone, $message, User $admin_user = null)
    {
        if (isset(\Yii::$app->params['notSMS']) and \Yii::$app->params['notSMS'] == true) return;
        if (sms::send($phone, $message))
            if ($admin_user) $admin_user->sendSMS($phone, $message);
    }

    private function mailerBooking($_email, BaseBooking $booking, $template, $attach_pdf = false) //BookingItemInterface
    {
        if (empty($_email)) {
            \Yii::error(['Нет почты уведомления', 'ID=' . $booking->id . ' / ' . $booking->object_id]);
            return;
        }
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
        if ($this->loc) return;
        $send = $this->mailer->compose($template, ['dialog' => $dialog, 'user_name' => $user_name])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Новое сообщение')])
            ->setSubject($dialog->theme->caption)
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendNewQuestion(string $email, FAQ $faq)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('noticeQuestion', ['faq' => $faq])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Переезд на ПМЖ')])
            ->setSubject('Новый вопрос на Форуме ПМЖ')
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendNewAnswer(FAQ $faq)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('noticeAnswer', ['faq' => $faq])
            ->setTo($faq->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Переезд на ПМЖ')])
            ->setSubject('Ответ на Ваш вопрос')
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendBookingLandowner(\booking\forms\realtor\BookingLandowner $form)
    {
        if ($this->loc) return;
        $send = $this->mailer->compose('bookingLandowner', ['form' => $form])
            ->setTo(\Yii::$app->params['landownerEmail'])
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Бронь на показ участка')])
            ->setSubject('Бронь на показ участка')
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }
    }

    public function sendReplyForum(\booking\entities\user\User $user, \booking\entities\forum\Message $message)
    {
        if (empty($user->email)) return;
        //if (true) return;
        $send = $this->mailer->compose('noticeReplyForum', ['message' => $message])
            ->setTo($user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => Lang::t('Форум портала Koenigs.ru')])
            ->setSubject('Вам ответили на Форуме')
            ->send();
        if (!$send) {
            throw new \DomainException(Lang::t('Ошибка отправки'));
        }

    }


}