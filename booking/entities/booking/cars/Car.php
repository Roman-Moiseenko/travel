<?php


namespace booking\entities\booking\cars;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\BaseObjectOfBooking;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\City;
use booking\entities\Meta;
use booking\entities\queries\ObjectActiveQuery;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;

/**
 * Class Car
 * @package booking\entities\booking\cars
 * @property integer $id
 * @property integer $legal_id
 * @property integer $user_id
 * @property integer $type_id - Тип (entities)
 * @property string $name - Марка
 * @property string $name_en - Марка
 * @property string $slug
 * @property integer $year - Год выпуска
 * @property string $description
 * @property string $description_en
 * @property integer $main_photo_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * ====== Финансы ===================================
 * @property integer $deposit - Залог
 * @property integer $cost - цена в сутки
 * @property integer $cancellation Отмена бронирования - нет/за сколько дней
 * @property integer $quantity - Количество автосредств данной модели
 * @property integer $discount_of_days - Скидка % при заказе более 3 дней
 * @property integer $prepay
 * @property float $rating
 * @property integer $views  Кол-во просмотров
 * @property integer $public_at Дата публикации
 * ====== Составные поля ===================================
 * @property BookingAddress[] $address
 * @property CarParams $params Возраст, Вод.права категория (entities), Стаж, мин.срок, Доставка
 * @property Meta $meta
 * ====== GET-Ы ============================================
 * @property Type $type
 * @property Photo $mainPhoto
 * @property ExtraAssignment[] $extraAssignments
 * @property ReviewCar[] $reviews
 * @property Extra[] $extra
 * @property Photo[] $photos
 * @property CostCalendar[] $actualCalendar
 * @property Legal $legal
 * @property Value[] $values
 * @property AssignmentCity[] $assignmentCities
 * @property City[] $cities
 * @property User $user
 * @property bool $params_age_on [tinyint(1)]
 * @property int $params_age_min [int]
 * @property int $params_age_max [int]
 * @property int $params_min_rent [int]
 * @property bool $params_delivery [tinyint(1)]
 * @property string $params_license [varchar(5)]
 * @property int $params_experience [int]
 * @property string $address_json [json]
 * @property string $meta_json
 * @property int $filling [int]
 */
class Car extends BaseObjectOfBooking
{
    const LICENSE = [
        'none' => 'none',
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
        'D' => 'D',
        'M' => 'M',
    ];
    public $address = [];
    public $params;
    public $limit;


    public static function create($name, $name_en, $type_id, $description, $description_en, $year): self
    {
        $car = new static();
        $car->user_id = \Yii::$app->user->id;
        $car->created_at = time();
        $car->status = StatusHelper::STATUS_INACTIVE;
        $car->name = $name;
        $car->slug = SlugHelper::slug($name); //?
        $car->type_id = $type_id;
        $car->description = $description;
        $car->name_en = $name_en;
        $car->description_en = $description_en;
        $car->year = $year;
        $car->quantity = 1;
        $car->meta = new Meta();
        $car->prepay = 100;

        return $car;
    }

    public function edit($name, $name_en, $type_id, $description, $description_en, $year): void
    {
        $this->name = $name;
        $this->slug = SlugHelper::slug($name); //?
        $this->type_id = $type_id;
        $this->description = $description;
        $this->name_en = $name_en;
        $this->year = $year;
        $this->description_en = $description_en;
    }

    public function setParams(CarParams $params)
    {
        $this->params = $params;
    }

    public function assignCity($id): void
    {
        $assignments = $this->assignmentCities;
        foreach ($assignments as $assignment) {
            if ($assignment->isFor($id)) {
                return;
            }
        }
        $assignments[] = AssignmentCity::create($id);
        $this->assignmentCities = $assignments;
    }

    public function revokeCity($id): void
    {
        $assignments = $this->assignmentCities;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isFor($id)) {
                unset($assignments[$i]);
                $this->assignmentCities = $assignments;
                return;
            }
        }
        throw new \DomainException('Город не найден.');
    }

    public function revokeCities(): void
    {
        $this->assignmentCities = [];
    }


    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function setDeposit($deposit)
    {
        $this->deposit = $deposit;
    }


    public function setDiscountOfDays($discount_of_days)
    {
        $this->discount_of_days = $discount_of_days;
    }

    public static function tableName()
    {
        return '{{%booking_cars}}';
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
                    'assignmentCities',
                ],
            ],
        ];
        return array_merge($relations, parent::behaviors());

    }

    public function afterFind(): void
    {
        $addresses = json_decode($this->getAttribute('address_json'), true);
        if ($addresses === null || count($addresses) == 0) {
            $this->address = [];
        } else {
            foreach ($addresses as $address) {
                $this->address[] = new BookingAddress($address['address'], $address['latitude'], $address['longitude']);
            }
        }

        $this->params = new CarParams(
            new AgeLimit(
                $this->getAttribute('params_age_on'),
                $this->getAttribute('params_age_min'),
                $this->getAttribute('params_age_max'),
            ),
            $this->getAttribute('params_min_rent'),
            $this->getAttribute('params_delivery'),
            $this->getAttribute('params_license'),
            $this->getAttribute('params_experience')
        );

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('address_json', json_encode($this->address));
        if ($this->params) {
            $this->setAttribute('params_age_on', $this->params->age->on);
            $this->setAttribute('params_age_min', $this->params->age->ageMin);
            $this->setAttribute('params_age_max', $this->params->age->ageMax);
            $this->setAttribute('params_min_rent', $this->params->min_rent);
            $this->setAttribute('params_delivery', $this->params->delivery);
            $this->setAttribute('params_license', $this->params->license);
            $this->setAttribute('params_experience', $this->params->experience);

        }
        return parent::beforeSave($insert);
    }


   /* public function addCostCalendar($car_at, $count, $cost)
    {
        $calendar = CostCalendar::create(
            $car_at,
            $cost,
            $count
        );
        $calendars = $this->actualCalendar;
        $calendars[] = $calendar;
        $this->actualCalendar = $calendars;
        return $calendar;
    }

    public function clearCostCalendar($new_day)
    {
        $calendars = $this->actualCalendar;
        foreach ($calendars as $i => $calendar) {
            if ($calendar->car_at === $new_day) {
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
        foreach ($calendars as $i => $calendar) {
            if ($calendar->car_at === $new_day) {
                unset($calendars[$i]);
            }
            if ($calendar->car_at === $copy_day) {

                $calendar_copy = CostCalendar::create(
                    $new_day,
                    $calendar->cost,
                    $calendar->count
                );
                $calendar_copy->car_at = $new_day;
                $temp_array[] = $calendar_copy;
            }
        }
        $this->actualCalendar = array_merge($calendars, $temp_array);
    }

    public function removeCostCalendar($id): bool
    {
        $calendars = $this->actualCalendar;
        foreach ($calendars as $i => $calendar) {
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

    /** getXXX ==========> */
    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['car_id' => 'id'])->orderBy('sort');
    }

    public function getExtraAssignments(): ActiveQuery
    {
        return $this->hasMany(ExtraAssignment::class, ['car_id' => 'id']);//->orderBy('sort');
    }

    public function getExtra(): ActiveQuery
    {
        return $this->hasMany(Extra::class, ['id' => 'extra_id'])->via('extraAssignments');
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getReviews(): ActiveQuery
    {
        /** Только активные отзывы */
        return $this->hasMany(ReviewCar::class, ['car_id' => 'id'])->andWhere([ReviewCar::tableName() . '.status' => BaseReview::STATUS_ACTIVE]);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::class, ['car_id' => 'id']);
    }

    public function getActualCalendar(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['car_id' => 'id']);
    }

    public function getAssignmentCities(): ActiveQuery
    {
        return $this->hasMany(AssignmentCity::class, ['car_id' => 'id']);
    }

    public function getCities(): ActiveQuery
    {
        return $this->hasMany(City::class, ['id' => 'city_id'])->via('assignmentCities');
    }

    public function linkAdmin(): string
    {
        return '/car/common?id=' . $this->id;
    }

    public function getVideos(): ActiveQuery
    {
        // TODO: Implement getVideos() method.
    }
}