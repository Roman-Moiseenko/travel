<?php

namespace booking\services;

use booking\entities\admin\user\User;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\ReviewInterface;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\Lang;
use booking\entities\message\Dialog;
use booking\helpers\BookingHelper;
use yii\mail\MailerInterface;

class ContactService
{
//TODO Контакт - Сервис протестировать на домене
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendNoticeReview(ReviewInterface $review)
    {
        $user_admin = $review->getAdmin();
        $noticeAdmin = $user_admin->notice;
        $legal = $review->getLegal();
        $phoneAdmin = $legal->noticePhone;
        $emailAdmin = $legal->noticeEmail;
        if ($noticeAdmin->review->phone)
            $this->sendSMS($phoneAdmin, 'Новый отзыв '. $review->getName());
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

    public function sendNoticeMessage(Dialog $dialog)
    {
        //TODO Отправка уведомления при новом письме
        // Провайдеру
        // Клиенту
        // в зависимости от типа, и кто author (!== тек.классу User) сообщения

    }

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
            //TODO  Параметры уведомлений клиента
            $this->sendSMS($phoneUser, Lang::t('У Вас новое бронирование ') . $booking->getName() . '.' . Lang::t('Не забудьте оплатить'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingNewUser');

            if ($noticeAdmin->bookingNew->phone)
                $this->sendSMS($phoneAdmin, 'Новое бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingNew->email)
                $this->sendEmailBooking($emailAdmin, $booking, 'noticeBookingNewAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_PAY) {
            //Бронирование оплачено  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Вы оплатили бронирование ') . $booking->getName() . '.' . Lang::t('Спасибо, что с нами'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingPayUser');
            if ($noticeAdmin->bookingPay->phone)
                $this->sendSMS($phoneAdmin, 'Подтверждено бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingPay->email)
                $this->sendEmailBooking($emailAdmin, $booking, 'noticeBookingPayAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL) {
            //Бронирование отменено  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Бронирование ') . $booking->getName() . ' ' . Lang::t('отменено'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingCancelUser');
            if ($noticeAdmin->bookingCancel->phone)
                $this->sendSMS($phoneAdmin, 'Отменено бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingCancel->email)
                $this->sendEmailBooking($emailAdmin, $booking, 'noticeBookingCancelAdmin');
        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL_PAY) {
            //Бронирование отменено с возвратом денег  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Бронирование ') . $booking->getName() . ' ' . Lang::t('отменено. Оплата поступит в течении 72 часов'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingCancelPayUser');
            if ($noticeAdmin->bookingCancelPay->phone)
                $this->sendSMS($phoneAdmin, 'Отменено оплаченое бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
            if ($noticeAdmin->bookingCancelPay->email)
                $this->sendEmailBooking($emailAdmin, $booking, 'noticeBookingCancelPayAdmin');
        }
    }

    private function sendSMS($phone, $message)
    {
        if (\Yii::$app->params['NotSend']) return;
        $result = \Yii::$app->sms->send($phone, $message);
        if (!$result)
            throw new \DomainException('Ошибка отправки СМС-сообщения');
    }

    private function sendEmailBooking($email, BookingItemInterface $booking, $template)
    {
        $send = $this->mailer->compose($template, ['booking' => $booking])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Уведомление о Бронировании'])
            ->setSubject($booking->getName() . ' ' . BookingHelper::caption($booking->getStatus()))
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }

    public function sendPetitionReview(ReviewInterface $review)
    {
        $send = $this->mailer->compose('petitionReview', ['review' => $review])
            ->setTo(\Yii::$app->params['supportEmail'])
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Петиция на отзыв'])
            ->setSubject($review->getName())
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }

    private function sendEmailReview($email, ReviewTour $review, $template)
    {
        $send = $this->mailer->compose($template, ['review' => $review])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Уведомление об отзыве'])
            ->setSubject('Тема') //TODO
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }

}