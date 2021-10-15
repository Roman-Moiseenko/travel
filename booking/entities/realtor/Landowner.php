<?php


namespace booking\entities\realtor;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Landowner
 * @package booking\entities\realtor
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $status .. активен или нет
 * @property integer $created_at
 *
 * Внутренние данные
 * @property string $caption ... ФИО или ООО
 * @property string $phone
 * @property string $email
 * Для списка
 * @property integer $cost ... В списке будет ЦЕНА ОТ ХХХ
 * @property string $description
 * @property integer $distance ... расстояние (км) до центра Калининграда
 * @property integer $count ... колво участков
 * @property integer $size ... минимальный размер участка
 *
 * Лэндинг
 * @property string $text
 * @property integer $main_photo_id
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 *
 * @property string $address_address [varchar(255)]
 * @property string $address_latitude [varchar(255)]
 * @property string $address_longitude [varchar(255)]
 * @property string $meta_json [json]
 *
 *
 */


class Landowner extends ActiveRecord
{
    /** @var $address BookingAddress */
    public $address; //Координаты участка
    /** @var $meta Meta */
    public $meta;

    public static function create($name, $slug, $caption, $phone, $email, $cost, $description, $distance, $count, $size,  $text, BookingAddress $address): self
    {
        $landowner = new static();
        $landowner->name = $name;
        $landowner->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        if (Landowner::find()->andWhere(['slug' => $landowner->slug])->one()) throw new \DomainException('Не уникален slug!!');

        $landowner->status = StatusHelper::STATUS_INACTIVE;
        $landowner->created_at = time();

        $landowner->caption = $caption;
        $landowner->phone = $phone;
        $landowner->email = $email;

        $landowner->cost = $cost;
        $landowner->description = $description;
        $landowner->distance = $distance;
        $landowner->count = $count;
        $landowner->size = $size;

        $landowner->text = $text;
        $landowner->address = $address;

        return $landowner;
    }

    public function edit($name, $slug, $caption, $phone, $email, $cost, $description, $distance, $count, $size,  $text, BookingAddress $address): void
    {
        $this->name = $name;
        $this->slug = empty($slug) ? SlugHelper::slug($name) : $slug;

        $this->caption = $caption;
        $this->phone = $phone;
        $this->email = $email;

        $this->cost = $cost;
        $this->description = $description;
        $this->distance = $distance;
        $this->count = $count;
        $this->size = $size;

        $this->text = $text;
        $this->address = $address;
    }

    public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public static function tableName()
    {
        return '{{%realtor_landowners}}';
    }

    public function behaviors()
    {
        return [
            BookingAddressBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'reviews',
                    'videos',
                ],
            ],
            MetaBehavior::class,
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
        //$this->updated_at = time();
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

    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['landowner_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }
}