<?php


namespace booking\entities\booking\hotels\rooms;

use booking\entities\booking\rooms\Beds;
use booking\entities\booking\hotels\rooms\Capacity;
use booking\entities\booking\hotels\rooms\Photo;
use booking\entities\booking\hotels\rooms\Type;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Rooms
 * @package booking\entities\booking\rooms
 * @property integer $id
 * @property integer $stays_id
 * @property string $name
 * @property integer $baseprice
 * @property integer $count
 * @property Capacity $capacity
 * @property float $square
 * @property integer $subrooms
 * @property integer $type_id
 * @property bool $smocking
 * @property Photo[] $photos
 * @property Type $type
 * @property Beds[] $beds
 */

class Rooms extends ActiveRecord
{

    public static function create($stays_id, $name, $baseprice , $square, Capacity $capacity, $type_id, $subrooms = 1, $count = 1): self
    {
        $rooms = new static();
        $rooms->$stays_id = $stays_id;
        $rooms->name = $name;
        $rooms->baseprice = $baseprice;
        $rooms->square = $square;
        $rooms->capacity = $capacity;
        $rooms->subrooms = $subrooms;
        $rooms->count = $count;
        $rooms->type_id = $type_id;
        return $rooms;
    }

    public function edit( $name, $baseprice , $square, Capacity $capacity, $type_id, $subrooms = 1, $count = 1): void
    {
        $this->name = $name;
        $this->baseprice = $baseprice;
        $this->square = $square;
        $this->capacity = $capacity;
        $this->subrooms = $subrooms;
        $this->count = $count;
        $this->type_id = $type_id;
    }

    public function setCount($count): void
    {
        $this->count = $count;
    }

    public static function tableName()
    {
        return '{{%booking_rooms}}';
    }
    public function afterFind(): void
    {

        $this->capacity = new Capacity(
            $this->getAttribute('capacityAdult'),
            $this->getAttribute('capacityChild')
        );

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('capacityAdult', $this->capacity->adult);
        $this->setAttribute('capacityChild', $this->capacity->child);

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

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['rooms_id' => 'id'])->orderBy('sort');
    }
    /** <========== getXXX */
}