<?php


namespace booking\entities\mailing;


use booking\entities\Lang;
use booking\helpers\scr;
use yii\db\ActiveRecord;

/**
 * Class Mailing
 * @package booking\entities
 * @property integer $id
 * @property string $subject
 * @property integer $created_at
 * @property integer $send_at
 * @property integer $status
 * @property integer $theme
 */
class Mailing extends ActiveRecord
{
    const NEWS_PROVIDER = 1; //Новости сайта для Провайдера
    const NEWS = 2; //Новости сайта для Клиентов
    const NEW_TOURS = 3; //Новые туры
    const NEW_CARS = 4; //Новые ТС
    const NEW_STAYS = 5; //Новое Жилье
    const NEW_FUNS = 6; //Новые развлечения
    const PROMOTIONS = 10; //Акции от провайдеров
    const NEWS_BLOG = 11; //Новые статьи в блоге

    const STATUS_NEW = 1;
    const STATUS_SEND = 2;


    public static function create($theme, $subject): self
    {
        $mailing = new static();
        $mailing->theme = $theme;
        $mailing->subject = $subject;
        $mailing->created_at = time();
        $mailing->status = self::STATUS_NEW;
        return $mailing;
    }

    public function edit($theme, $subject): void
    {
        $this->theme = $theme;
        $this->subject = $subject;
    }

    public function send(): void
    {
        $this->status = self::STATUS_SEND;
        $this->send_at = time();
    }

    public function isSend(): bool
    {
        return $this->status == self::STATUS_SEND;
    }

    public static function tableName()
    {
        return '{{%mailing}}';
    }

    public static function listTheme()
    {
        $result = [
            self::NEWS_PROVIDER => 'Новости сайта для Провайдеров',
            self::NEWS => 'Новости сайта',
            self::NEW_TOURS => 'Обзор новых туров',
            self::NEW_CARS => 'Обзор новых автосредств для проката',
            self::NEW_STAYS => 'Обзор нового жилья',
            self::NEW_FUNS => 'Обзор новых развлечений',
            self::PROMOTIONS => 'Акции от Провайдеров',
            self::NEWS_BLOG => 'Новые записи в блоге',
        ];
        return $result;
    }

    public static function listToFrontend()
    {
        $result = [
            self::NEW_TOURS => 'Обзор новых туров',
            self::NEW_CARS => 'Обзор новых автосредств',
            self::NEW_STAYS => 'Обзор нового жилья',
            self::NEW_FUNS => 'Обзор новых развлечений',
            self::PROMOTIONS => 'Акции от Провайдеров',
            self::NEWS_BLOG => 'Новые записи в блоге',
        ];
        return $result;
    }

    public static function nameTheme($type)
    {
        return self::listTheme()[$type];
    }

}