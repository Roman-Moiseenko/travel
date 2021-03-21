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
 *
* Выплаты
 * @property float $payment_provider - оплата провайдеру
 * @property float $pay_merchant - % оплаты клиентом комиссии: 0 - оплачивает провайдер
 * @property string $payment_id - ID платежа по ЮКассе
 * @property integer $payment_at - дата оплаты
 * @property float $payment_merchant - оплата комиссии банку (в руб)
 * @property float $payment_deduction - оплата вознаграждения порталу (в руб)
 * @property string $confirmation - код подтверждения, для неоплачиваемых
 * @property integer $pincode
 * @property boolean $unload
 * @property integer $guest_add
 * @property string $comment
 * @property CostCalendar[] $calendars
 * @property BookingStayOnDay[] $days
 * @property Stay $stay
 * @property \booking\entities\user\User $user
 * @property \booking\entities\check\User $checkUser
 * @property int $payment_date [int]
 * @property int $payment_full_cost [int]
 * @property int $payment_prepay [int]
 * @property int $payment_percent [int]
 * @property string $payment_confirmation [varchar(255)]
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
        return $this->stay->getName();
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
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
    {
        return $this->stay->mainPhoto->getThumbFileUrl('file', $photo);
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_STAY;
    }

    public function getAdd(): string
    {
        // TODO: Implement getAdd() method.
    }


    public function getAdmin(): User
    {
        return $this->stay->user;
    }


    public function quantity(): int
    {
        // TODO: Implement quantity() method.
    }

    public function isPaidLocally(): bool
    {
        return $this->stay->prepay == 0;
    }

    public function getCalendar(): ActiveQuery
    {
        // TODO: Implement getCalendar() method.
    }

    public function getCalendars(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['id' => 'calendar_id'])->via('days');
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
        return $this->stay->prepay;
    }

    public function getStay(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'object_id']);
    }
}