<?php


namespace booking\entities\booking;


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
use yii\web\UploadedFile;

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
 * @property Meta $meta
 * ====== Финансы ===================================
 * @property integer $cancellation Отмена бронирования - нет/за сколько дней
 * @property integer $prepay
 *
 * ====== Внешние связи ============================================
 * @property Legal $legal
 * @property User $user
 * @property BasePhoto[] $photos
 *
 * @property string $meta_json
 */
abstract class BaseObjectOfBooking extends ActiveRecord
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
            MetaBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
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



    /** Photo ==========>
     * @param BasePhoto $photo
     */

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

    /** <========== Photo */
}