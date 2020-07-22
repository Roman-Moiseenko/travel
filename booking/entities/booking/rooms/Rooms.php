<?php


namespace booking\entities\booking\rooms;

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
 * @property integer $capacity
 * @property float $square
 * @property integer $subrooms
 * @property Photo[] $photos
 */

class Rooms extends ActiveRecord
{

    public static function create($stays_id, $name, $baseprice , $square, $capacity, $subrooms = 1, $count = 1): self
    {
        $rooms = new static();
        $rooms->$stays_id = $stays_id;
        $rooms->name = $name;
        $rooms->baseprice = $baseprice;
        $rooms->square = $square;
        $rooms->capacity = $capacity;
        $rooms->subrooms = $subrooms;
        $rooms->count = $count;
        return $rooms;
    }

    public function edit($stays_id, $name, $baseprice , $square, $capacity, $subrooms = 1, $count = 1): void
    {
        $this->$stays_id = $stays_id;
        $this->name = $name;
        $this->baseprice = $baseprice;
        $this->square = $square;
        $this->capacity = $capacity;
        $this->subrooms = $subrooms;
        $this->count = $count;
    }

    public static function tableName()
    {
        return '{{%booking_rooms}}';
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

}