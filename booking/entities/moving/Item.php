<?php


namespace booking\entities\moving;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BookingAddress;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Item
 * @package booking\entities\moving
 * @property integer $id
 * @property integer $page_id
 * @property integer $main_photo_id
 * @property string $title ... h2
 * @property string $text
 * @property integer $rating
 * @property integer $sort
 * @property integer $post_id
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property string $address_address [varchar(255)]
 * @property string $address_latitude [varchar(255)]
 * @property string $address_longitude [varchar(255)]
 */
class Item extends ActiveRecord
{
    /** @var $address BookingAddress */
    public $address;

    public static function create($title, $text, BookingAddress $address, $post_id): self
    {
        $item = new static();
        $item->title = $title;
        $item->text = $text;
        $item->address = $address;
        $item->post_id = $post_id;
        return $item;
    }

    public function edit($title, $text, BookingAddress $address, $post_id): void
    {
        $this->title = $title;
        $this->text = $text;
        $this->address = $address;
        $this->post_id = $post_id;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public static function tableName()
    {
        return '{{%moving_pages_item}}';
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

    public function transactions(): array
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

    //**** Фото (Photo) **********************************

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
    //**** Внешние связи **********************************

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['item_id' => 'id'])->orderBy('sort');
    }

    public function isFor($item_id): bool
    {
        return $this->id == $item_id;
    }

}