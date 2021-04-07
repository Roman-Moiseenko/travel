<?php


namespace booking\entities\booking;


use booking\ActivateObjectInterface;
use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BaseObjectOfBooking
 * @package booking\entities\booking
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
 * @property int $filling [int]
 * @property integer $views  Кол-во просмотров
 * @property integer $public_at Дата публикации
 * @property string $meta_json - Хранение  мета-параметров
 * @property Meta $meta
 * ====== Финансы ===================================
 * @property integer $cancellation Отмена бронирования - нет/за сколько дней
 * @property integer $prepay
 *
 * ====== Внешние связи ============================================
 * @property Legal $legal
 * @property User $user
 * @property BasePhoto[] $photos
 * @property BaseReview[] $reviews
 * @property BaseCalendar[] $actualCalendar
 *
 */
abstract class BaseObjectOfBooking extends ActiveRecord implements ActivateObjectInterface
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

    public function isConfirmation(): bool
    {
        return $this->prepay == 0;
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

    public function isCancellation($date)
    {
        if ($this->cancellation == null) return false;
        if ($date <= time()) return false;
        if (($date - time()) / (24 * 3600) < $this->cancellation) return false;
        return true;
    }

    public function isNew(): bool
    {
        if ($this->public_at == null) return false;
        return (time() - $this->public_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

//====== SET-ы         ============================================

    public function setPrepay($prepay)
    {
        $this->prepay = $prepay;
    }

    public function setLegal($legalId)
    {
        $this->legal_id = $legalId;
    }

    public function setCancellation($cancellation)
    {
        $this->cancellation = $cancellation;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

//====== GET-ы         ============================================

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

//====== Внешние связи ============================================
    abstract public function getActualCalendar(): ActiveQuery;

    abstract public function getMainPhoto(): ActiveQuery;

    abstract public function getReviews(): ActiveQuery;

    abstract public function getPhotos(): ActiveQuery;

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

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

    public function addPhotoClass(BasePhoto $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
        $this->updatePhotos($photos);
    }

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

//**** Календарь (CostCalendar) **********************************

    public function addCostCalendar(BaseCalendar $calendar): BaseCalendar
    {
        $calendars = $this->actualCalendar;
        $calendars[] = $calendar;
        $this->actualCalendar = $calendars;
        return $calendar;
    }

    public function clearCostCalendar($new_day)
    {
        $calendars = $this->actualCalendar;
        foreach ($calendars as $i => $calendar) {
            if ($calendar->getDate_at() === $new_day) unset($calendars[$i]);
        }
        $this->actualCalendar = $calendars;
        return;
    }

    public function copyCostCalendar($new_day, $copy_day)
    {
        /** @var BaseCalendar $calendars */
        $calendars = $this->actualCalendar;
        $temp_array = [];
        foreach ($calendars as $i => $calendar) {
            if ($calendar->getDate_at() === $new_day) {
                unset($calendars[$i]);
            }
            if ($calendar->getDate_at() === $copy_day) {
                $temp_array[] = $calendar->cloneDate($new_day);
            }
        }
        $this->actualCalendar = array_merge((array)$calendars, $temp_array);
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
}