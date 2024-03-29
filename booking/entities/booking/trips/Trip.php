<?php


namespace booking\entities\booking\trips;

use booking\entities\booking\BaseObjectOfBooking;
use booking\entities\booking\BaseReview;
use booking\entities\booking\trips\activity\Activity;
use booking\entities\booking\trips\placement\Placement;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;

/**
 * Class Trip
 * @package booking\entities\booking\trips
 * @property integer $id
 * @property integer $user_id
 * @property integer $legal_id
 * @property string $name
 * @property string $name_en
 * @property string $slug
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $main_photo_id
 * @property integer $status
 * @property string $description
 * @property string $description_en
 * @property integer $type_id
 * @property float $rating
 * @property integer $filling
 * @property integer $views  Кол-во просмотров
 * @property integer $public_at Дата публикации
 * @property integer $cost_base
 * @property TypeAssignment[] $typeAssignments
 * @property Type[] $types
 * @property Type $type
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property Video[] $videos
 * @property PlacementAssignment[] $placementAssignments
 * @property Placement[] $placements
 * @property int $params_duration [int]
 * @property int $params_transfer [int]
 * @property int $params_capacity [int]
 * @property Activity[] $activities
 */
class Trip extends BaseObjectOfBooking
{
    /** @var $params TripParams */
    public $params;

    public static function create($user_id, $name, $name_en, $description, $description_en, $type_id, $slug): self
    {
        $trip = new static();

        $trip->user_id = $user_id;
        $trip->type_id = $type_id;
        $trip->created_at = time();
        $trip->status = StatusHelper::STATUS_INACTIVE;
        $trip->name = $name;
        $trip->description = $description;
        $trip->name_en = $name_en;
        $trip->description_en = $description_en;
        $trip->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        if (Trip::find()->andWhere(['slug' => $trip->slug])->one()) $trip->slug .= '-' . $trip->user_id;
        $trip->prepay = 100;
        $trip->meta = new Meta();
        return $trip;
    }

    public function edit($name, $name_en, $description, $description_en, $type_id, $slug)
    {
        $this->name = $name;
        $this->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $this->type_id = $type_id;
        $this->description = $description;
        $this->name_en = $name_en;
        $this->description_en = $description_en;
    }

    public function setParams(TripParams $params): void
    {
        $this->params = $params;
    }

    public function setCost($cost): void
    {
        $this->cost_base = $cost;
    }

    public function isPlacementAssign($id): bool
    {
        foreach ($this->placementAssignments as $assignment) {
            if ($assignment->isFor($id)) return true;
        }
        return false;
    }

    public function minAmount(): int
    {
        $amount = 0;
        return $amount;
    }

    public static function tableName()
    {
        return '{{%booking_trips}}';
    }

    public function behaviors()
    {
        $relations =
            [
                [
                    'class' => SaveRelationsBehavior::class,
                    'relations' => [
                        'typeAssignments',
                        'placementAssignments',
                        'actualCalendar',
                    ],
                ],
            ];
        return array_merge($relations, parent::behaviors());
    }

    public function afterFind(): void
    {
        $this->params = new TripParams(
            $this->getAttribute('params_duration') ?? null,
            $this->getAttribute('params_transfer') ?? null,
            $this->getAttribute('params_capacity') ?? null
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        if ($this->params) {
            $this->setAttribute('params_duration', $this->params->duration);
            $this->setAttribute('params_transfer', $this->params->transfer);
            $this->setAttribute('params_capacity', $this->params->capacity);
        }
        return parent::beforeSave($insert);
    }

    //**** Категории дополнительные (AssignType) **********************************

    public function assignPlacement($id): void
    {
        $assigns = $this->placementAssignments;
        foreach ($assigns as $assign) {
            if ($assign->isFor($id)) {
                return;
            }
        }
        $assigns[] = PlacementAssignment::create($id);
        $this->placementAssignments = $assigns;
    }

    public function revokePlacement($id): void
    {
        $assigns = $this->placementAssignments;
        foreach ($assigns as $i => $assign) {
            if ($assign->isFor($id)) {
                unset($assigns[$i]);
                $this->placementAssignments = $assigns;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function clearPlacement(): void
    {
        $this->placementAssignments = [];
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

    //******  Внешние связи **************************
    public function getActualCalendar(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['trip_id' => 'id'])->orderBy(['trip_at' => SORT_ASC]);
    }


    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getReviews(): ActiveQuery
    {
        /** Только активные отзывы */
        return $this->hasMany(ReviewTrip::class, ['trip_id' => 'id'])
            ->andWhere([ReviewTrip::tableName() . '.status' => BaseReview::STATUS_ACTIVE]);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['trip_id' => 'id'])->orderBy('sort');
    }

    public function getTypeAssignments(): ActiveQuery
    {
        return $this->hasMany(TypeAssignment::class, ['trip_id' => 'id']);//->orderBy('sort');
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getTypes(): ActiveQuery
    {
        return $this->hasMany(Type::class, ['id' => 'type_id'])->via('typeAssignments');
    }

    public function getPlacementAssignments(): ActiveQuery
    {
        return $this->hasMany(PlacementAssignment::class, ['trip_id' => 'id']);//->orderBy('sort');
    }

    public function getPlacements(): ActiveQuery
    {
        return $this->hasMany(Placement::class, ['id' => 'placement_id'])->via('placementAssignments');
    }

    public function getActivities(): ActiveQuery
    {
        return $this->hasMany(Activity::class, ['trip_id' => 'id']);
    }


    public function linkAdmin(): string
    {
        return '/trip/common?id=' . $this->id;
    }

    public function getVideos(): ActiveQuery
    {
        return $this->hasMany(Video::class, ['trip_id' => 'id'])->orderBy(['sort' => SORT_ASC]);

    }

    //************************

    public function activityDayTimeSort(): array
    {
        $result = [];
        foreach ($this->activities as $activity) {
            $result[$activity->day][$activity->time][] = $activity;
        }
        return $result;
    }

    public function getAddressesActivities()
    {
        return [];
    }
}