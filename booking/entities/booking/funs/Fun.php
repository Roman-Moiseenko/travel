<?php


namespace booking\entities\booking\funs;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\queries\FunQueries;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\entities\Meta;
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
 * @property integer $check_booking - Оплата через портал или  провайдера
 * @property integer $quantity - Количество автосредств данной модели
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
 */

class Fun extends ActiveRecord
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
    public $meta;


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
        $fun->check_booking = BookingHelper::BOOKING_CONFIRMATION;
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

    /** finance Data */
    public function setLegal($legalId)
    {
        $this->legal_id = $legalId;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setCost($cost)
    {
        $this->baseCost = $cost;
    }

    public function setCancellation($cancellation)
    {
        $this->cancellation = $cancellation;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setCheckBooking($check_booking)
    {
        $this->check_booking = $check_booking;
    }


    public function isConfirmation(): bool
    {
        return $this->check_booking == BookingHelper::BOOKING_CONFIRMATION;
    }

    public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    public function isVerify(): bool
    {
        return $this->status === StatusHelper::STATUS_VERIFY;
    }

    public function isDraft(): bool
    {
        return $this->status === StatusHelper::STATUS_DRAFT;
    }

    public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_INACTIVE;
    }

    public function isLock()
    {
        return $this->status === StatusHelper::STATUS_LOCK;
    }

    public function isMulti(): bool
    {
        return $this->multi;
    }

    public function isCancellation($date_fun)
    {
        if ($this->cancellation == null) return false;
        if ($date_fun <= time()) return false;
        if (($date_fun - time()) / (24 * 3600) < $this->cancellation) return false;
        return true;
    }

    public function upViews(): void
    {
        $this->views++;
    }

    public function isNew(): bool
    {
        if ($this->public_at == null) return false;
        return (time() - $this->public_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public static function tableName()
    {
        return '{{%booking_funs}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'extraAssignments',
                    'values',
                    'reviews',
                    'actualCalendar',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
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

    public function afterSave($insert, $changedAttributes)
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
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

    /** Review  ==========>*/

    public function addReview($userId, $vote, $text): ReviewFun
    {
        $reviews = $this->reviews;
        $review = ReviewFun::create($userId, $vote, $text);
        $reviews[] = $review;
        $this->updateReviews($reviews);
        return $review;
    }

    public function editReview($id, $vote, $text): void
    {

        $reviews = $this->reviews;
        foreach ($reviews as $review) {
            if ($review->isIdEqualTo($id)) {
                $review->edit($vote, $text);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден');
    }

    public function removeReview($id): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Отзыв не найден');
    }

    public function countReviews(): int
    {
        $reviews = $this->reviews;
        return count($reviews);
    }

    private function updateReviews(array $reviews): void
    {
        $total = 0;
        /* @var ReviewFun $review */
        foreach ($reviews as $review) {
            $total += $review->getRating();
        }
        $this->reviews = $reviews;
        $this->rating = count($reviews) == 0 ? 0 : $total / count($reviews);
    }

    /** <==========  Reviews  */

    /** Photo ==========> */

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
        $this->updated_at = time();
    }

    public function removePhoto($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Фото не найдено.');
    }

    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    /** <========== Photo */

    /** CostCalendar  ==========> */

    public function addCostCalendar($fun_at, $time_at, $tickets, $cost_adult, $cost_child = null, $cost_preference = null): CostCalendar
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
    }
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
        return $this->hasMany(ReviewFun::class, ['fun_id' => 'id'])->andWhere([ReviewFun::tableName() .'.status' => ReviewFun::STATUS_ACTIVE]);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
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

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /** <========== getXXX */

    public static function find(): FunQueries
    {
        return new FunQueries(static::class);
    }

}