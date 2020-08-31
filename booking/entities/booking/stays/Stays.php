<?php


namespace booking\entities\booking\stays;


use booking\entities\admin\user\UserLegal;
use booking\entities\booking\rooms\Rooms;
use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\rules\Rules;
use booking\entities\booking\BookingAddress;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Stays
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $user_id
 * @property integer $legal_id
 * @property integer $created_at
 * @property string $name
 * @property integer $status
 * @property integer $stars
 * @property float $rating
 * @property integer $main_photo_id
 * @property integer $type_id
 * @property BookingAddress $address
 * @property Photo[] $photos
 * @property ReviewStay[] $reviews
 * @property Rooms[] $rooms
 * @property Type $type
 * @property Rules $rules
 * @property Comfort[] $comforts
 * @property Nearby[] $nearby
 *
 */
class Stays extends ActiveRecord
{
    const STATUS_LOCK = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    public $address;


    public static function create($name, $typeId, BookingAddress $address, $stars = 0): self
    {
        $stays = new static();
        $stays->created_at = time();
        $stays->name = $name;
        $stays->status = Stays::STATUS_INACTIVE;
        $stays->type_id = $typeId;
        $stays->address = $address;
        $stays->stars = $stars;
        return $stays;
    }

    public function edit($name, $legalId, BookingAddress $address, $stars = 0): void
    {
        $this->name = $name;
        $this->legal_id = $legalId;
        $this->address = $address;
        $this->stars = $stars;
    }

    public function setLegal($legalId): void
    {
        $this->legal_id = $legalId;
    }

    public function setRules(Rules $rules)
    {
        $this->rules = $rules;
    }
    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Жилище уже активировано');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function inactivate(): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('Жилище уже деактивировано');
        }
        $this->status = self::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    public static function tableName()
    {
        return '{{%booking_stays}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                   // 'categoryAssignments',
                   // 'values',
                    'photos',
                   // 'tagAssignments',
                  //  'relatedAssignments',
                    'rules',
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

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_address'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('adr_address', $this->address->address);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);
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

    /** Review  ==========>*/

    public function addReview($userId, $vote, $text): ReviewStay
    {
        $reviews = $this->reviews;
        $review = ReviewStay::create($userId, $vote, $text);
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
        /* @var ReviewStay $review */
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
    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(UserLegal::class, ['id' => 'legal_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewStay::class, ['stays_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['stays_id' => 'id'])->orderBy('sort');
    }

    public function getRooms(): ActiveQuery
    {
        return $this->hasMany(Rooms::class, ['stays_id' => 'id'])->orderBy('sort');
    }

    public function getRules(): ActiveQuery
    {
        return $this->hasOne(Rules::class, ['stays_id' => 'id']);
    }

    public function getComforts(): ActiveQuery
    {
        return $this->hasOne(Comfort::class, ['stays_id' => 'id']);
    }

    public function getNearby(): ActiveQuery
    {
        return $this->hasOne(Nearby::class, ['stays_id' => 'id']);
    }
    /** <========== getXXX */
}