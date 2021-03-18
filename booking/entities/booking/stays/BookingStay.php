<?php


namespace booking\entities\booking\stays;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\Discount;
use booking\entities\booking\LinkBooking;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class BookingStay
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $user_id
 * @property integer $stay_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $begin_at
 * @property integer $end_at

Выплаты
 * @property float $payment_provider - оплата провайдеру
 * @property float $pay_merchant - % оплаты клиентом комиссии: 0 - оплачивает провайдер
 * @property string $payment_id - ID платежа по ЮКассе
 * @property integer $payment_at - дата оплаты
 * @property float $payment_merchant - оплата комиссии банку (в руб)
 * @property float $payment_deduction - оплата вознаграждения порталу (в руб)
 * @property string $confirmation - код подтверждения, для неоплачиваемых

 * @property integer $pincode
 * @property boolean $unload

 * @property integer $discount_id
 * @property integer $guest_add
 * @property string $comment
 * @property Discount $discount
 * @property integer $bonus

 * @property CostCalendar[] $calendars
 * @property BookingStayOnDay[] $days
 * @property Stay $stay
 * @property \booking\entities\user\User $user
 * @property \booking\entities\check\User $checkUser
 */
class BookingStay extends BaseBooking
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

    public function getLinks(): LinkBooking
    {
        $link = new LinkBooking(
            Url::to(['stay/common', 'id' => $this->object_id]),
            Url::to(['stay/booking/index', 'id' => $this->object_id]),
            Url::to(['cabinet/stay/view', 'id' => $this->id]),
            Url::to(['cabinet/pay/stay', 'id' => $this->id]),
            Url::to(['cabinet/stay/cancelpay', 'id' => $this->id]),
            Url::to(['stay/view', 'id' => $this->object_id]),
            Url::to(['stays/view', 'id' => $this->object_id])
        );
        return $link;
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

    public function getCount(): int
    {
        // TODO: Implement getCount() method.
    }

    public function isCheckBooking(): bool
    {
        // TODO: Implement isCheckBooking() method.
    }

    public function isNew(): bool
    {
        // TODO: Implement isNew() method.
    }

    public function quantity(): int
    {
        // TODO: Implement quantity() method.
    }

    public function isPaidLocally(): bool
    {
        // TODO: Implement isPaidLocally() method.
    }

    public function getCalendar(): ActiveQuery
    {
        // TODO: Implement getCalendar() method.
    }

    public function getCalendars(): ActiveQuery
    {
        // TODO: Implement getCalendars() method.
    }

    public function getDays(): ActiveQuery
    {
        // TODO: Implement getDays() method.
    }

    protected function getFullCostFrom(): float
    {
        // TODO: Implement getFullCostFrom() method.
    }

    protected function getPrepayFrom(): int
    {
        // TODO: Implement getPrepayFrom() method.
    }
}