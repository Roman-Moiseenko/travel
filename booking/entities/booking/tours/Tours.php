<?php


namespace booking\entities\booking\tours;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\stays\Geo;
use booking\entities\booking\stays\rules\AgeLimit;
use booking\entities\booking\tours\queries\ToursQueries;
use booking\helpers\SlugHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Tours
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $slug
 * @property integer $legal_id
 * @property integer $created_at
 * @property integer $main_photo_id
 * @property integer $status
 * @property string $description
 * @property integer type_id
 * @property float $rating
 * @property integer $cancellation
 * @property BookingAddress $address
 * @property ExtraAssignment[] $extraAssignments
 * @property Review[] $reviews
 * @property Type $type
 * @property ToursParams $params
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property Cost $baseCost
 * @property TypeAssignment[] $typeAssignments
 */
class Tours extends ActiveRecord
{
    const STATUS_LOCK = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    public $address;
    public $params;
    public $baseCost;

    /** base Data */
    public static function create($name, $type_id, $description, BookingAddress $address): self
    {
        $tours = new static();
        $tours->created_at = time();
        $tours->status = Tours::STATUS_INACTIVE;
        $tours->name = $name;
        $tours->slug = SlugHelper::slug($name);
        $tours->type_id = $type_id;
        $tours->address = $address;
        $tours->description = $description;
        return $tours;
    }

    public function edit($name, $type_id, $description, BookingAddress $address)
    {
        $this->name = $name;
        $this->type_id = $type_id;
        $this->address = $address;
        $this->description = $description;
    }

    /** params Data */
    public function setParams(ToursParams $params)
    {
        $this->params = $params;
    }

    /** finance Data */
    public function setLegal($legalId)
    {
        $this->legal_id = $legalId;
    }

    public function setCost(Cost $baseCost)
    {
        $this->baseCost = $baseCost;
    }

    public function setCancellation($cancellation)
    {
        $this->cancellation = $cancellation;
    }

    public function isCancellation()
    {
        return $this->cancellation == null ? true : false;
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'typeAssignments',
                    'extraAssignments',
                    'reviews'
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

    public static function tableName()
    {
        return '{{%booking_tours}}';
    }

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_town'),
            $this->getAttribute('adr_street'),
            $this->getAttribute('adr_house'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );


        $this->params = new ToursParams(
            $this->getAttribute('params_duration'),
            new BookingAddress(
                $this->getAttribute('params_begin_town'),
                $this->getAttribute('params_begin_street'),
                $this->getAttribute('params_begin_house'),
                $this->getAttribute('params_begin_latitude'),
                $this->getAttribute('params_begin_longitude')
            ),
            new BookingAddress(
                $this->getAttribute('params_end_town'),
                $this->getAttribute('params_end_street'),
                $this->getAttribute('params_end_house'),
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
            $this->getAttribute('params_groupMax'),
            $this->getAttribute('params_children')
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
        $this->setAttribute('adr_town', $this->address->town);
        $this->setAttribute('adr_street', $this->address->street);
        $this->setAttribute('adr_house', $this->address->house);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);

        $this->setAttribute('params_duration', $this->params->duration);
        $this->setAttribute('params_begin_town', $this->params->beginAddress->town);
        $this->setAttribute('params_begin_street', $this->params->beginAddress->street);
        $this->setAttribute('params_begin_house', $this->params->beginAddress->house);
        $this->setAttribute('params_begin_latitude', $this->params->beginAddress->latitude);
        $this->setAttribute('params_begin_longitude', $this->params->beginAddress->longitude);
        $this->setAttribute('params_end_town', $this->params->beginAddress->town);
        $this->setAttribute('params_end_street', $this->params->beginAddress->street);
        $this->setAttribute('params_end_house', $this->params->beginAddress->house);
        $this->setAttribute('params_end_latitude', $this->params->beginAddress->latitude);
        $this->setAttribute('params_end_longitude', $this->params->beginAddress->longitude);
        $this->setAttribute('params_limit_on', $this->params->agelimit->on);
        $this->setAttribute('params_limit_min', $this->params->agelimit->ageMin);
        $this->setAttribute('params_limit_max', $this->params->agelimit->ageMax);
        $this->setAttribute('params_private', $this->params->private);
        $this->setAttribute('params_groupMin', $this->params->groupMin);
        $this->setAttribute('params_groupMax', $this->params->groupMax);
        $this->setAttribute('params_children', $this->params->children);

        $this->setAttribute('cost_adult', $this->baseCost->adult);
        $this->setAttribute('cost_child', $this->baseCost->child);
        $this->setAttribute('cost_preference', $this->baseCost->preference);

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

    /** AssignType ==========> */

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

    /** <========== AssignType */

    /** Review  ==========>*/

    public function addReview($userId, $vote, $text): Review
    {
        $reviews = $this->reviews;
        $review = Review::create($userId, $vote, $text);
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

    private function updateReviews(array $reviews): void
    {
        $total = 0;
        /* @var Review $review */
        foreach ($reviews as $review) {
            $total += $review->getRating();
        }
        $this->reviews = $reviews;
        $this->rating = $total / count($reviews);
    }

    /** <==========  Reviews  */

    /** Photo ==========> */

    public function addPhotoClass(Photo $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
        $this->updatePhotos($photos);
    }

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
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


    /** getXXX ==========> */
    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['tours_id' => 'id'])->orderBy('sort');
    }

    public function getExtraAssignments(): ActiveQuery
    {
        return $this->hasMany(ExtraAssignment::class, ['tours_id' => 'id'])->orderBy('sort');
    }

    public function getTypeAssignments(): ActiveQuery
    {
        return $this->hasMany(TypeAssignment::class, ['tours_id' => 'id'])->orderBy('sort');
    }

    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['tours_id' => 'id']);
    }
    /** <========== getXXX */

    public static function find(): ToursQueries
    {
        return new ToursQueries(static::class);
    }
}