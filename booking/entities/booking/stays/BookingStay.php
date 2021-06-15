<?php


namespace booking\entities\booking\stays;


use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\LinkBooking;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\SysHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class BookingStay
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $begin_at
 * @property integer $end_at
 *
 * @property integer $guest - Кол-во гостей (взрослых, с оплатой)
 * @property integer $children - Кол-во детей (без оплаты)
 * @property float $payment_provider - оплата провайдеру
 * @property string $payment_id - ID платежа по ЮКассе
 * @property integer $payment_at - дата оплаты
 * @property float $payment_merchant - оплата комиссии банку (в руб)
 * @property float $payment_deduction - оплата вознаграждения порталу (в руб)

 * @property integer $pincode
 * @property boolean $unload

 * @property string $comment
 * @property CostCalendar[] $calendars
 * @property BookingStayOnDay[] $days
 * @property BookingStayServices[] $services
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

    public static function create($stay_id, $date_from, $date_to, $guest, $children, array $children_age, array $services): self
    {
        $booking = new static();
        $booking->object_id = $stay_id;
        $booking->begin_at = SysHelper::_renderDate($date_from);
        $booking->end_at = SysHelper::_renderDate($date_to) - 24 * 60 * 60;
        //Проверка на детей возраст, попадают ли они под взрослых
        $stay = Stay::findOne($stay_id);

        if ($children > 0) {
            $n = $children;
            for($i = 0; $i < $n; $i ++) {
                if ($children_age[$i] >= $stay->rules->beds->child_by_adult) {$guest++; $children--;}
            }
            if ($children > $guest)  {
                $guest = round(($children + $guest) / 2);
                $children = $children - $guest;
            }
        }

        $booking->guest = $guest;
        $booking->children = $children;

        $calendars = CostCalendar::find()->andWhere(['stay_id' => $stay_id])->andWhere(['>=', 'stay_at', $booking->begin_at])->andWhere(['<=', 'stay_at', $booking->end_at])->all();
        if (count($calendars) == 0) throw new \DomainException(Lang::t('Неверный диапозон дат'));
        foreach ($calendars as $calendar) {
            if ($calendar->free() == 0) {
                throw new \DomainException(Lang::t('Недостаточно свободных на дату ') . date('d-m-Y', $calendar->stay_at));
            };
            $booking->addDay($calendar->id);
        }

        foreach ($services as $service) {
            $booking->addService($service);
        }
        $booking->initiate($stay_id, $calendars[0]->stay->legal_id, \Yii::$app->user->id, $calendars[0]->stay->prepay);

        return $booking;
    }

    public function isCancellation(): bool
    {
        return $this->stay->isCancellation($this->begin_at);
    }


    public function addService($service_id)
    {
        $services = $this->services;
        $service = $this->stay->getServicesById($service_id);
        $services[] = BookingStayServices::create($service->name, $service->value, $service->payment);
        $this->services = $services;
    }

    public static function tableName()
    {
        return '{{%booking_stays_calendar_booking}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'days',
                    'services',
                ],
            ],
        ];
    }

    public function addDay($calendar_id)
    {
        $days = $this->days;
        $days[] = BookingStayOnDay::create($calendar_id);
        $this->days = $days;
    }

    public function getDate(): int
    {
        return $this->begin_at;
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
        return $this->stay->main_photo_id ? $this->stay->mainPhoto->getThumbFileUrl('file', $photo) : '';
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_STAY;
    }

    public function getAdd(): string
    {
        return date('d-m-Y', $this->end_at);
    }

    public function getAdmin(): User
    {
        return $this->stay->user;
    }

    public function quantity(): int
    {
        return 1;
    }

    public function isPaidLocally(): bool
    {
        return $this->stay->prepay == 0;
    }

    public function getCalendar(): ActiveQuery
    {
        throw new \DomainException('Не используется');
    }

    public function getCalendars(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['id' => 'calendar_id'])->via('days');
    }

    public function getDays(): ActiveQuery
    {
        return $this->hasMany(BookingStayOnDay::class, ['booking_id' => 'id']);
    }

    protected function getFullCostFrom(): float
    {
        $cost = 0;
        foreach ($this->calendars as $calendar) {
            $add_guest = ($this->guest > $calendar->guest_base) ? ($this->guest - $calendar->guest_base) : 0;
            $cost += $calendar->cost_base + $add_guest * $calendar->cost_add;
        }
        $days = count($this->calendars);
        $cost_service = 0;
        foreach ($this->services as $service) {
            $cost_service += $service->cost($this->guest, $days, $cost);
        }
        return $cost + $cost_service;
    }

    protected function getPrepayFrom(): int
    {
        return $this->stay->prepay;
    }

    public function getStay(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'object_id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasMany(BookingStayServices::class, ['booking_id' => 'id']);
    }

    public function getInfoNotice(): string
    {
        return  '';
    }
}