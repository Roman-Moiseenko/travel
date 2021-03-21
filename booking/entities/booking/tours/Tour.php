<?php


namespace booking\entities\booking\tours;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BaseObjectOfBooking;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
//use booking\entities\booking\stays\Geo;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\tours\queries\TourQueries;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Tours
 * @package booking\entities\booking\tours
 * Общие параметры *****************************
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $name_en
 * @property string $slug
 * @property integer $legal_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $main_photo_id
 * @property integer $status
 * @property string $description
 * @property string $description_en
 * @property integer type_id
 * @property float $rating
 * @property integer $filling
 * @property integer $views  Кол-во просмотров
 * @property integer $public_at Дата публикации
 * @property Meta $meta
 *
 * ====== Финансы
 * @property integer $cancellation Отмена бронирования - нет/за сколько дней
 * @property integer $prepay
 *
 * ====== Внешние связи
 * @property Legal $legal
 * @property User $user
 *
 * Специфические параметры*****************************
 * ====== Составные поля ==============================
 * @property TourParams $params

 * ====== Внешние связи ===============================
 * @property Type $type
 * @property Photo $mainPhoto
 * @property ExtraAssignment[] $extraAssignments
 * @property ReviewTour[] $reviews
 * @property Type[] $types
 * @property Extra[] $extra
 * @property Photo[] $photos
 * @property TypeAssignment[] $typeAssignments
 * @property CostCalendar[] $actualCalendar

 * @property string $adr_address [varchar(255)]
 * @property string $adr_latitude [varchar(255)]
 * @property string $adr_longitude [varchar(255)]
 * @property string $params_duration [varchar(255)]
 * @property string $params_begin_address [varchar(255)]
 * @property string $params_begin_latitude [varchar(255)]
 * @property string $params_begin_longitude [varchar(255)]
 * @property string $params_end_address [varchar(255)]
 * @property string $params_end_latitude [varchar(255)]
 * @property string $params_end_longitude [varchar(255)]
 * @property bool $params_limit_on [tinyint(1)]
 * @property int $params_limit_min [int]
 * @property int $params_limit_max [int]
 * @property bool $params_private [tinyint(1)]
 * @property int $params_groupMin [int]
 * @property int $params_groupMax [int]
 * @property bool $params_children [tinyint(1)]
 * @property int $cost_adult [int]
 * @property int $cost_child [int]
 * @property int $cost_preference [int]
 * @property string $meta_json
 * @property string $params_annotation [varchar(255)]

 */
class Tour extends BaseObjectOfBooking
{

    /** @var $address BookingAddress */
    public $address;
    public $params;
    /** @var $baseCost Cost */
    public $baseCost;

    public static function create($name, $type_id, $description, BookingAddress $address, $name_en, $description_en, $slug): self
    {
        $tour = new static();
        $tour->user_id = \Yii::$app->user->id;
        $tour->created_at = time();
        $tour->status = StatusHelper::STATUS_INACTIVE;
        $tour->name = $name;
        $tour->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        if (Tour::find()->andWhere(['slug' => $tour->slug])->one()) $tour->slug .= '-' . $tour->user_id;
        $tour->type_id = $type_id;
        $tour->address = $address;
        $tour->description = $description;
        $tour->name_en = $name_en;
        $tour->description_en = $description_en;
        $tour->prepay = 100;
        $tour->meta = new Meta();
        return $tour;
    }

    public function edit($name, $type_id, $description, BookingAddress $address, $name_en, $description_en, $slug)
    {
        $this->name = $name;
        $this->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $this->type_id = $type_id;
        $this->address = $address;
        $this->description = $description;
        $this->name_en = $name_en;
        $this->description_en = $description_en;
    }

    public function setParams(TourParams $params)
    {
        $this->params = $params;
    }

    public function setCost(Cost $baseCost)
    {
        $this->baseCost = $baseCost;
    }

    public function isPrivate(): bool
    {
        return $this->params->private == true;
    }


    public function behaviors()
    {
        $relations =
             [
                [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'typeAssignments',
                    'extraAssignments',
                    'actualCalendar',
                ],
            ],
        ];
        return array_merge($relations, parent::behaviors());
    }


    public static function tableName()
    {
        return '{{%booking_tours}}';
    }

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_address'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );

        $this->params = new TourParams(
            $this->getAttribute('params_duration'),
            new BookingAddress(
                $this->getAttribute('params_begin_address'),
                $this->getAttribute('params_begin_latitude'),
                $this->getAttribute('params_begin_longitude')
            ),
            new BookingAddress(
                $this->getAttribute('params_end_address'),
                $this->getAttribute('params_end_latitude'),
                $this->getAttribute('params_end_longitude')
            ),
            new AgeLimit(
                $this->getAttribute('params_limit_on'),
                $this->getAttribute('params_limit_min'),
                $this->getAttribute('params_limit_max'),
            ),
            $this->getAttribute('params_private'),
            $this->getAttribute('params_groupMin'),
            $this->getAttribute('params_groupMax')
        );

        $this->baseCost = new Cost(
            $this->getAttribute('cost_adult'),
            $this->getAttribute('cost_child'),
            $this->getAttribute('cost_preference'),
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('adr_address', $this->address->address);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);

        if ($this->params) {
            $this->setAttribute('params_duration', $this->params->duration);
            $this->setAttribute('params_begin_address', $this->params->beginAddress->address);
            $this->setAttribute('params_begin_latitude', $this->params->beginAddress->latitude);
            $this->setAttribute('params_begin_longitude', $this->params->beginAddress->longitude);
            $this->setAttribute('params_end_address', $this->params->endAddress->address);
            $this->setAttribute('params_end_latitude', $this->params->endAddress->latitude);
            $this->setAttribute('params_end_longitude', $this->params->endAddress->longitude);
            $this->setAttribute('params_limit_on', $this->params->agelimit->on);
            $this->setAttribute('params_limit_min', $this->params->agelimit->ageMin);
            $this->setAttribute('params_limit_max', $this->params->agelimit->ageMax);
            $this->setAttribute('params_private', $this->params->private);
            $this->setAttribute('params_groupMin', $this->params->groupMin);
            $this->setAttribute('params_groupMax', $this->params->groupMax);
        }
        if ($this->baseCost) {
            $this->setAttribute('cost_adult', $this->baseCost->adult);
            $this->setAttribute('cost_child', $this->baseCost->child);
            $this->setAttribute('cost_preference', $this->baseCost->preference);
        }

        return parent::beforeSave($insert);
    }

//**** Дополнения (AssignExtra) **********************************

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

//**** Категории дополнительные (AssignType) **********************************

    public function assignType($id): void
    {
        $assigns = $this->typeAssignments;
        foreach ($assigns as $assign) {
            if ($assign->isFor($id)) {
                return;
            }
        }
        $assigns[] = TypeAssignment::create($id);
        $this->typeAssignments = $assigns;
    }

    public function revokeType($id): void
    {
        $assigns = $this->typeAssignments;
        foreach ($assigns as $i => $assign) {
            if ($assign->isFor($id)) {
                unset($assigns[$i]);
                $this->typeAssignments = $assigns;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function clearType(): void
    {
        $this->typeAssignments = [];
    }

//**** Календарь (CostCalendar) **********************************

 /*   public function addCostCalendar($tour_at, $time_at, $tickets, $cost_adult, $cost_child = null, $cost_preference = null): CostCalendar
    {
        $calendar = CostCalendar::create(
            $tour_at,
            $time_at,
            new Cost($cost_adult, $cost_child, $cost_preference),
            $tickets
        );
        $calendars = $this->actualCalendar;
        $calendars[] = $calendar;
        $this->actualCalendar = $calendars;
        return $calendar;
    }*/

  /*  public function clearCostCalendar($new_day)
    {
        $calendars = $this->actualCalendar;
        foreach ($calendars as $i => $calendar) {
            if ($calendar->tour_at === $new_day) {
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
            if ($calendar->tour_at === $new_day) {
                unset($calendars[$i]);
            }
            if ($calendar->tour_at === $copy_day) {

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
                $calendar_copy->tour_at = $new_day;
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
    }
*/

//**** Внешние связи **********************************

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['tours_id' => 'id'])->orderBy('sort');
    }

    public function getExtraAssignments(): ActiveQuery
    {
        return $this->hasMany(ExtraAssignment::class, ['tours_id' => 'id']);//->orderBy('sort');
    }

    public function getExtra(): ActiveQuery
    {
        return $this->hasMany(Extra::class, ['id' => 'extra_id'])->via('extraAssignments');
    }

    public function getTypeAssignments(): ActiveQuery
    {
        return $this->hasMany(TypeAssignment::class, ['tours_id' => 'id']);//->orderBy('sort');
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
        return $this->hasMany(ReviewTour::class, ['tour_id' => 'id'])
            ->andWhere([ReviewTour::tableName() . '.status' => BaseReview::STATUS_ACTIVE]);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getActualCalendar(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['tours_id' => 'id'])->orderBy(['tour_at' => SORT_ASC]);
    }


    public static function find(): TourQueries
    {
        return new TourQueries(static::class);
    }

}