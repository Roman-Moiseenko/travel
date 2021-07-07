<?php


namespace booking\entities\booking\trips\activity;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BookingAddress;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Activity
 * @package booking\entities\booking\trips\activity
 * @property integer $id
 * @property integer $trip_id
 * @property integer $day ... день от начала тура, начиная с 1го дня. Если == 0, то это перечень мероприятий по желанию, "согласовываются на месте"
 * @property string $time ... пусто, начало, начало-конец
 * @property integer $cost
 * @property string $caption
 * @property string $caption_en
 * @property string $description
 * @property string $description_en
 * @property integer $main_photo_id
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 *
 * @property string $address_address
 * @property string $address_latitude
 * @property string $address_longitude
 */
class Activity extends ActiveRecord
{

    /** @var $address BookingAddress */
    public $address;

    public static function create($trip_id, $day, $time, $caption, $caption_en, $description, $description_en, $cost, BookingAddress $address): self
    {
        $activity = new static();
        $activity->trip_id = $trip_id;
        $activity->day = $day;
        $activity->time = $time;
        $activity->caption = $caption;
        $activity->caption_en = $caption_en;
        $activity->description = $description;
        $activity->description_en = $description_en;
        $activity->cost = $cost;
        $activity->address = $address;
        return $activity;
    }

    public function edit($day, $time, $caption, $caption_en, $description, $description_en, $cost, BookingAddress $address): void
    {
        $this->day = $day;
        $this->time = $time;
        $this->caption = $caption;
        $this->caption_en = $caption_en;
        $this->description = $description;
        $this->description_en = $description_en;
        $this->cost = $cost;
        $this->address = $address;
    }

    public static function tableName()
    {
        return '{{%booking_trips_activity}}';
    }

    public function behaviors()
    {
        return [
            BookingAddressBehavior::class,
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

    //====== Photo         ============================================

    public function addPhoto(BasePhoto $photo): void
    {
        $photos = $this->photos;
        $photos[] = $photo;
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

    protected function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['activity_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

}