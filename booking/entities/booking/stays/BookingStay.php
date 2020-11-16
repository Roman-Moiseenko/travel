<?php


namespace booking\entities\booking\stays;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
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

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['stay/booking/index', 'id' => $this->id]),
            'frontend' => Url::to(['cabinet/stay/view', 'id' => $this->id]),
        ];
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
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

    public function getLegal(): Legal
    {
        // TODO: Implement getLegal() method.
    }

    public function getCreated(): int
    {
        return $this->created_at;
    }

    /**
     * @inheritDoc
     */
    public function getParentId(): int
    {
        // TODO: Implement getParentId() method.
    }

    public function getConfirmationCode(): string
    {
        return $this->confirmation;
    }

    public function getPinCode(): int
    {
        return $this->pincode;
    }

    public function setPaymentId(string $payment_id)
    {
        $this->payment_id = $payment_id;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения payment_id - ') . $payment_id);
        }
    }

    public function getAmountDiscount(): float
    {
        // TODO: Implement getAmountDiscount() method.
    }

    public function getMerchant(): float
    {
        // TODO: Implement getMerchant() method.
    }

    public function getAmountPayAdmin(): float
    {
        // TODO: Implement getAmountPayAdmin() method.
    }

    public function getPaymentToProvider(): float
    {
        // TODO: Implement getPaymentToProvider() method.
    }



    public function getCheckBooking(): int
    {
        // TODO: Implement getCheckBooking() method.
    }

    public function setGive()
    {
        // TODO: Implement setGive() method.
    }

    /** is.. */
    public function isPay(): bool
    {
        // TODO: Implement isPay() method.
    }

    public function isConfirmation(): bool
    {
        // TODO: Implement isConfirmation() method.
    }

    public function isCancel(): bool
    {
        // TODO: Implement isCancel() method.
    }
}