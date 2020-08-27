<?php


namespace booking\entities\booking\stays;


use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class BookingStay extends ActiveRecord implements BookingItemInterface
{



    public static function tableName()
    {
        return '{{%booking_stays_calendar_booking}}';
    }

    /** ==========> Interface для личного кабинета */

    public function getDate(): int
    {
        // TODO: Implement getDate() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getLink(): string
    {
        return Url::to(['cabinet/stay/view', 'id' => $this->id]);
    }

    public function getPhoto(): string
    {
        // TODO: Implement getPhoto() method.
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_STAY;
    }

    public function getAdd(): string
    {
        // TODO: Implement getAdd() method.
    }

    public function getStatus(): int
    {
         return $this->status;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка изменения статуса'));
        }
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAdmin(): User
    {
        // TODO: Implement getAdminId() method.
    }

    public function getLegal(): UserLegal
    {
        // TODO: Implement getLegal() method.
    }
}