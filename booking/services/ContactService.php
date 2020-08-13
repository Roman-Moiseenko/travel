<?php

namespace shop\services;

use booking\entities\booking\tours\Review;
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






}