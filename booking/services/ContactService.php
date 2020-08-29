<?php

namespace booking\services;

use booking\entities\admin\user\User;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\ReviewInterface;
use booking\entities\booking\tours\Review;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use yii\mail\MailerInterface;

class ContactService
{
//TODO Контакт - Сервис СДЕЛАТЬ!!!!!!!!!!!!!!!!!
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

        //TODO
        $email = '';
        $send = $this->mailer->compose('noticeAdminReview', ['review' => $review])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Новый отзыв'])
            ->setSubject('Новый отзыв о товаре')
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }

    public function sendNoticeMessage()
    {

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

    private function sendEmailReview($email, Review $review, $template)
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