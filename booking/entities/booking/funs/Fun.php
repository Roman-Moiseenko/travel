<?php


namespace booking\entities\booking\funs;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\BaseObjectOfBooking;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\entities\queries\ObjectActiveQuery;
use booking\entities\WorkMode;
use booking\helpers\BookingHelper;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Fun
 * @package booking\entities\booking\funs
 * @property integer $id
 * @property integer $legal_id
 * @property integer $user_id
 * @property integer $type_id - Тип (entities)
 * @property string $times_json - поле хранения данных в БД
 * @property integer $type_time - способ формирования цены календаря по времени
 * @property string $name - Название
 * @property string $name_en - Название
 * @property string $slug
 * @property string $description
 * @property string $description_en
 * @property integer $main_photo_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property bool $multi
 * ====== Финансы ===================================
 * @property integer $cancellation Отмена бронирования - нет/за сколько дней
 * @property integer $quantity - Количество автосредств данной модели
 * @property integer $prepay
 *
 *
 * @property float $rating
 * @property integer $views  Кол-во просмотров
 * @property integer $public_at Дата публикации
 *
 * ====== Составные поля ===================================
 * @property BookingAddress $address
 * @property Times[] $times - список времени
 * @property FunParams $params
 * @property Cost $baseCost Цена на билет взрослый, дети, льготные
 * @property Meta $meta
 * ====== GET-Ы ============================================
 * @property Type $type
 * @property Photo $mainPhoto
 * @property ExtraAssignment[] $extraAssignments
 * @property ReviewFun[] $reviews
 * @property Extra[] $extra
 * @property Photo[] $photos
 * @property CostCalendar[] $actualCalendar
 * @property Legal $legal
 * @property Value[] $values
 * @property User $user
 * ====== Скрытые поля ===================================
 * @property int $cost_adult [int]
 * @property int $cost_child [int]
 * @property int $cost_preference [int]
 * @property string $adr_address [varchar(255)]
 * @property string $adr_latitude [varchar(255)]
 * @property string $adr_longitude [varchar(255)]
 * @property bool $params_limit_on [tinyint(1)]
 * @property int $params_limit_min [int]
 * @property int $params_limit_max [int]
 * @property string $params_annotation [varchar(255)]
 * @property string $params_work_mode [json]
 * @property string $meta_json
 * @property int $filling [int]
 */

class Fun extends BaseObjectOfBooking
{
    const TYPE_TIME_FULLDAY = 1; //весь день
    const TYPE_TIME_WEEKEND = 2; //билет выходного дня (сб, вс)
    const TYPE_TIME_EXACT = 3; //точное начало, неограниченная продолжительность
    const TYPE_TIME_EXACT_FULL = 4; //точное начало, точное окончание
    const TYPE_TIME_INTERVAL = 5; // ежечасно с .. по ...

    const TYPE_TIME_ARRAY = [
        self::TYPE_TIME_FULLDAY => 'В течение дня', //весь день
        self::TYPE_TIME_WEEKEND => 'Билет выходного дня', //билет выходного дня (сб, вс)
        self::TYPE_TIME_EXACT => 'Точное начало', //точное начало, неограниченная продолжительность
        self::TYPE_TIME_EXACT_FULL => 'Точное начало и окончание', //точное начало, точное окончание
        self::TYPE_TIME_INTERVAL => 'Ежечасно', // ежечасно с .. по ...
    ];

    public $address;
    public $params;
    public $baseCost;
    public $times;


    public static function isClearTimes($type): bool
    {
        return $type == self::TYPE_TIME_FULLDAY || $type == self::TYPE_TIME_WEEKEND;
    }

    public static function create($name, $description, $type_id, BookingAddress $address, $name_en, $description_en): self
    {
        $fun = new static();
        $fun->name = $name;
        $fun->description = $description;
        $fun->type_id = $type_id;
        $fun->address = $address;
        $fun->name_en = $name_en;
        $fun->description_en = $description_en;

        $fun->user_id = \Yii::$app->user->id;
        $fun->slug = SlugHelper::slug($name); //?
        $fun->created_at = time();
        $fun->status = StatusHelper::STATUS_INACTIVE;
        $fun->quantity = 1;
        $fun->times = [];
        //Заполняем массив недели
        $workModes = [];
        for ($i = 0; $i < 7; $i++) {
            $workModes[] = new WorkMode();
        }
        $fun->params = new FunParams(new AgeLimit(), '', $workModes);
        $fun->meta = new Meta();

        if ($fun->type->isMulti()) {
            $fun->type_time = self::TYPE_TIME_INTERVAL;
            $fun->multi = true;
        }
        $fun->prepay = 100;

        return $fun;
    }

    public static function getTimesByInterval($begin, $end, $step): array
    {
        $today_string = date('d-m-Y', time());
        $_begin = strtotime($today_string . ' ' . $begin);
        $_end = strtotime($today_string . ' ' . $end);
        $_step = strtotime($today_string . ' ' . $step) - strtotime($today_string);
        $result = [];
        for ($i = $_begin; $i < $_end; $i += $_step) {
            $result[] = new Times(date('H:i', $i), date('H:i', $i + $_step));
        }
        return $result;
    }

    public function edit($name, $description, $type_id, BookingAddress $address, $name_en, $description_en): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->type_id = $type_id;
        $this->address = $address;
        $this->name_en = $name_en;
        $this->description_en = $description_en;
        if ($this->type->isMulti()) {
            $this->type_time = self::TYPE_TIME_INTERVAL;
            $this->multi = true;
        }
    }

    public function setParams(FunParams $params)
    {
        $this->params = $params;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setCost($cost)
    {
        $this->baseCost = $cost;
    }

    public function isMulti(): bool
    {
        return $this->multi;
    }

    public static function tableName()
    {
        return '{{%booking_funs}}';
    }

    public function behaviors()
    {
        $relations = [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'extraAssignments',
                    'values',
                    'actualCalendar',
                ],
            ],
        ];
        return array_merge($relations, parent::behaviors());

    }

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_address'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );
        $workMode = [];
        $_w = json_decode($this->getAttribute('params_work_mode'), true);
        for ($i = 0; $i < 7; $i++) {
            if (isset($_w[$i])) {
                $workMode[$i] = new WorkMode($_w[$i]['day_begin'], $_w[$i]['day_end'], $_w[$i]['break_begin'], $_w[$i]['break_end']);
            } else {
                $workMode[$i] = new WorkMode();
            }
        }

        $this->params = new FunParams(
            new AgeLimit(
                $this->getAttribute('params_limit_on'),
                $this->getAttribute('params_limit_min'),
                $this->getAttribute('params_limit_max'),
            ),
            $this->getAttribute('params_annotation'),
            $workMode
        );

        $this->baseCost = new Cost(
            $this->getAttribute('cost_adult'),
            $this->getAttribute('cost_child'),
            $this->getAttribute('cost_preference'),
        );
        $this->times = array_map(function ($item) {
            return new Times($item['begin'] ?? null, $item['end'] ?? null);
        },
            json_decode($this->getAttribute('times_json'), true));

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('adr_address', $this->address->address);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);

        if ($this->params) {
            $this->setAttribute('params_limit_on', $this->params->ageLimit->on);
            $this->setAttribute('params_limit_min', $this->params->ageLimit->ageMin);
            $this->setAttribute('params_limit_max', $this->params->ageLimit->ageMax);
            $this->setAttribute('params_annotation', $this->params->annotation);
            $this->setAttribute('params_work_mode', json_encode($this->params->workMode));
        }
        if ($this->baseCost) {
            $this->setAttribute('cost_adult', $this->baseCost->adult);
            $this->setAttribute('cost_child', $this->baseCost->child);
            $this->setAttribute('cost_preference', $this->baseCost->preference);
        }
        $this->setAttribute('times_json', json_encode($this->times));

        return parent::beforeSave($insert);
    }


    /** AssignExtra ==========> */

    public function assignExtra($id): void
    {
        $assigns = $this->extraAssignments;
        foreach ($assigns as $assign) {
            if ($assign->isFor($id)) {
                return;
            }
        }
        $assigns[] = ExtraAssignment::create($id);
        $this->extraAssignments = $assigns;
    }

    public function isExtra($id): bool
    {
        $assigns = $this->extraAssignments;
        foreach ($assigns as $assign) {
            if ($assign->isFor($id)) {
                return true;
            }
        }
        return false;
    }

    public function revokeExtra($id): void
    {
        $assigns = $this->extraAssignments;
        foreach ($assigns as $i => $assign) {
            if ($assign->isFor($id)) {
                unset($assigns[$i]);
                $this->extraAssignments = $assigns;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function clearExtra(): void
    {
        $this->extraAssignments = [];
    }

    /** <========== AssignExtra */


    /** CostCalendar  ==========> */

 /*   public function addCostCalendar($fun_at, $time_at, $tickets, $cost_adult, $cost_child = null, $cost_preference = null): CostCalendar
    {
        $calendar = CostCalendar::create(
            $fun_at,
            $time_at,
            new Cost($cost_adult, $cost_child, $cost_preference),
            $tickets
        );
        $calendars = $this->actualCalendar;
        $calendars[] = $calendar;
        $this->actualCalendar = $calendars;
        return $calendar;
    }

    public function clearCostCalendar($new_day)
    {
        $calendars = $this->actualCalendar;
        foreach ($calendars as $i =>$calendar) {
            if ($calendar->fun_at === $new_day) {
                unset($calendars[$i]);
            }
        }
        $this->actualCalendar = $calendars;
        return;
    }

    public function copyCostCalendar($new_day, $copy_day)
    {
        $calendars = $this->actualCalendar;
        $temp_array = [];
        foreach ($calendars as $i =>$calendar) {
            if ($calendar->fun_at === $new_day) {
                unset($calendars[$i]);
            }
            if ($calendar->fun_at === $copy_day) {

                $calendar_copy = CostCalendar::create(
                    $new_day,
                    $calendar->time_at,
                    new Cost(
                        $calendar->cost->adult,
                        $calendar->cost->child,
                        $calendar->cost->preference
                    ),
                    $calendar->tickets
                );
                $calendar_copy->fun_at = $new_day;
                $temp_array[] = $calendar_copy;
            }
        }
        $this->actualCalendar = array_merge($calendars, $temp_array);
    }

    public function removeCostCalendar($id): bool
    {
        $calendars = $this->actualCalendar;
        foreach ($calendars as $i => $calendar)
        {
            if ($calendar->isFor($id)) {
                if ($calendar->isEmpty()) {
                    unset($calendars[$i]);
                    $this->actualCalendar = $calendars;
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }*/
    /** <==========  CostCalendar  */

    /** Value ==========> */
    public function setValue($id, $value): void
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                $val->change($value);
                $this->values = $values;
                return;
            }
        }
        $values[] = Value::create($id, $value);
        $this->values = $values;
    }


    public function getValue($id): Value
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                return $val;
            }
        }
        return Value::blank($id);
    }

    public function clearValues(): void
    {
        $this->values = null;
    }
    /** <========== Value */

    /** getXXX ==========> */
    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['fun_id' => 'id'])->orderBy('sort');
    }

    public function getExtraAssignments(): ActiveQuery
    {
        return $this->hasMany(ExtraAssignment::class, ['fun_id' => 'id']);//->orderBy('sort');
    }

    public function getExtra(): ActiveQuery
    {
        return $this->hasMany(Extra::class, ['id' => 'extra_id'])->via('extraAssignments');
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getTypes(): ActiveQuery
    {
        return $this->hasMany(Type::class, ['id' => 'type_id'])->via('typeAssignments');
    }

    public function getReviews(): ActiveQuery
    {
        /** Только активные отзывы */
        return $this->hasMany(ReviewFun::class, ['fun_id' => 'id'])->andWhere([ReviewFun::tableName() .'.status' => BaseReview::STATUS_ACTIVE]);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }


    public function getActualCalendar(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['fun_id' => 'id'])->orderBy(['fun_at' => SORT_ASC]);
    }

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::class, ['fun_id' => 'id']);
    }

    public function linkAdmin(): string
    {
        return '/fun/common?id=' . $this->id;
    }
}