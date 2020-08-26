<?php

namespace booking\services;

use booking\entities\admin\user\User;
use booking\entities\booking\BookingItemInterface;
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


    public function sendNoticeReview(Review $review)
    {
        //Уведомления в магазин
      /*  if (!$email = ParamsHelper::get('emailOrder')) {
            throw new \DomainException('Не найден почтовый адрес администратора');
        }
*/
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


    public function sendNoticeBooking(BookingItemInterface $booking)
    {
        $user_admin_id = $booking->getAdminId();
        $user_admin = User::findOne($user_admin_id);
        $phoneUser = '';
        $phoneAdmin = '';
        $emailUser = '';
        $emailAdmin = '';
        //Получаем параметры уведомления
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_NEW) {
            //Новое бронирование  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('У Вас новое бронирование ') . $booking->getName() . '.' . Lang::t('Не забудьте оплатить'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingNewUser');
            $this->sendSMS($phoneAdmin, 'Новое бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
            $this->sendEmailBooking($emailAdmin, $booking, 'noticeBookingNewAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_PAY) {
            //Бронирование оплачено  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Вы оплатили бронирование ') . $booking->getName() . '.' . Lang::t('Спасибо, что с нами'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingPayUser');
            $this->sendSMS($phoneAdmin, 'Подтверждено бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
            $this->sendEmailBooking($emailAdmin, $booking, 'noticeBookingPayAdmin');

        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL) {
            //Бронирование отменено  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Бронирование ') . $booking->getName() . ' ' . Lang::t('отменено'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingCancelUser');
            $this->sendSMS($phoneAdmin, 'Отменено бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
            $this->sendEmailBooking($emailAdmin, $booking, 'noticeBookingCancelAdmin');
        }
        if ($booking->getStatus() == BookingHelper::BOOKING_STATUS_CANCEL_PAY) {
            //Бронирование отменено с возвратом денег  => Рассылка
            $this->sendSMS($phoneUser, Lang::t('Бронирование ') . $booking->getName() . ' ' . Lang::t('отменено. Оплата поступит в течении 72 часов'));
            $this->sendEmailBooking($emailUser, $booking, 'noticeBookingCancelPayUser');
            $this->sendSMS($phoneAdmin, 'Отменено оплаченое бронирование '. $booking->getName() . ' на сумму ' . $booking->getAmount());
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



}