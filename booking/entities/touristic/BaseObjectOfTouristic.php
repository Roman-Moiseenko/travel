<?php


namespace booking\entities\touristic;



use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\behaviors\TouristicContactBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\queries\ObjectActiveQuery;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BaseObjectOfBooking
 * @package booking\entities\touristic
 * Общие параметры *****************************
 * @property integer $id
 * @property integer $category_id - Тип (entities)
 * @property string $name - Название
 * @property string $title - H1
 * @property string $slug
 * @property string $description ... на странице категории
 * @property string $content
 * @property string $phone
 * @property string $url
 * @property string $email
 * @property integer $sort
 *
 * @property integer $main_photo_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property float $rating
 * @property integer $featured_at
 *
 * ====== Внешние связи ============================================
 * @property BasePhoto[] $photos
 * @property BaseReview[] $reviews
 *
 */
abstract class BaseObjectOfTouristic extends ActiveRecord
{
    /** @var $meta Meta */
    public $meta;
    /** @var $address BookingAddress */
    public $address;

    public function upViews(): void
    {
        $this->views++;
    }

//====== is-ы          ============================================

    public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_INACTIVE;
    }

    public function isFeatured(): bool
    {
        return $this->featured_at > time();
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

//====== SET-ы         ============================================
    public function activated()
    {
        $this->status = StatusHelper::STATUS_ACTIVE;
    }

    public function inactivated()
    {
        $this->status = StatusHelper::STATUS_INACTIVE;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

//====== GET-ы         ============================================

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

//====== Внешние связи ============================================

    abstract public function getMainPhoto(): ActiveQuery;

    abstract public function getReviews(): ActiveQuery;

    abstract public function getPhotos(): ActiveQuery;

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'reviews',
                ],
            ],
            MetaBehavior::class,
            TimestampBehavior::class,
            BookingAddressBehavior::class,
            TouristicContactBehavior::class,
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }

//====== Photo         ============================================

    public function addPhoto(BasePhoto $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
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

    protected function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

//====== Review        ============================================

    public function addReview(BaseReview $review): BaseReview
    {
        $reviews = $this->reviews;
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
        /* @var BaseReview $review */
        foreach ($reviews as $review) {
            $total += $review->getRating();
        }
        $this->reviews = $reviews;
        $this->rating = $total / count($reviews);
    }


    //*******************************//
    public static function find(): ObjectActiveQuery
    {
        return new ObjectActiveQuery(static::class);
    }
}