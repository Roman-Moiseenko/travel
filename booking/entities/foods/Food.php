<?php


namespace booking\entities\foods;


use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\queries\FoodQueries;
use booking\entities\Meta;
use booking\helpers\BookingHelper;
use DomainException;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Food
 * @package booking\entities\foods
 *
 ********************************** Основные поля
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $visible
 * @property integer $main_photo_id
 * @property string $name
 * @property string $description
 * @property float $rating
 *
 ********************************* Внешние связи
 * @property InfoAddress[] $addresses
 * @property Kitchen[] $kitchens Тип кухни
 * @property KitchenAssign[] $kitchenAssign
 * @property Category[] $categories ... Доставка (без столиков) Ресторан, Кафе, Уличное кафе, Бар, Пивной паб
 * @property CategoryAssign[] $categoryAssign
 * @property Contact[] $contacts
 * @property ContactAssign[] $contactAssign
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property ReviewFood[] $reviews
 *
 *********************************** Скрытые поля
 * @property Meta $meta
 * @property string $meta_json
 * @property string $work_mode_json
 */
class Food extends ActiveRecord
{
    /** @var Meta $meta */
    public $meta;
    /** @var WorkMode[] $workModes */
    public $workModes = [];

    public static function create($name, $description): self
    {
        $food = new static();
        $food->name = $name;
        $food->description = $description;
        $food->created_at = time();
        $food->meta = new Meta();
        $food->visible = false;
        for ($i = 0; $i < 7; $i++) {
            $food->workModes[] = new WorkMode();
        }
        return $food;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getDescription():string
    {
        return $this->description;
    }

    public function edit(string $name, string $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setWorkMode(array $workModes): void
    {
        $this->workModes = $workModes;
    }

    public function visible(): void
    {
        $this->visible = true;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function isNew(): bool
    {
        if ($this->created_at == null) return false;
        return (time() - $this->created_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

    public static function tableName()
    {
        return '{{%foods}}';
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
                    'reviews',
                    'contactAssign',
                    'kitchenAssign',
                    'categoryAssign',
                    'addresses',
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

    public function afterFind()
    {
        parent::afterFind();
        $workMode = [];
        $_w = json_decode($this->getAttribute('work_mode_json'), true);
        for ($i = 0; $i < 7; $i++) {
            if (isset($_w[$i])) {
                $workMode[$i] = new WorkMode($_w[$i]['day_begin'], $_w[$i]['day_end'], $_w[$i]['break_begin'], $_w[$i]['break_end']);
            } else {
                $workMode[$i] = new WorkMode();
            }
        }
        $this->workModes = $workMode;
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('work_mode_json', json_encode($this->workModes));
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

    //**** Адреса (InfoAddress) **********************************

    public function addAddress(InfoAddress $address)
    {
        $addresses = $this->addresses;
        $addresses[] = $address;
        $this->addresses = $addresses;
    }

    public function removeAddress($id)
    {
        $addresses = $this->addresses;
        foreach ($addresses as $i => $address) {
            if ($address->isFor($id)) {
                unset($addresses[$i]);
                $this->addresses = $addresses;
                return;
            }
        }
        throw new DomainException('Адрес не найден');
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
        throw new DomainException('Фото не найдено.');
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
        throw new DomainException('Фото не найдено.');
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
        throw new DomainException('Фото не найдено.');
    }

    protected function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    //**** Отзывы (Review) **********************************

    public function addReview(ReviewFood $review): ReviewFood
    {
        $reviews = $this->reviews;
        $reviews[] = $review;
        $this->updateReviews($reviews);
        return $review;
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
        throw new DomainException('Отзыв не найден');
    }

    public function countReviews(): int
    {
        $reviews = $this->reviews;
        return count($reviews);
    }

    private function updateReviews(array $reviews): void
    {
        $this->reviews = $reviews;
        if (count($reviews) == 0) {
            $this->rating = 0;
            return;
        }
        $total = 0;
        /* @var ReviewFood $review */
        foreach ($reviews as $review) {
            $total += $review->getRating();
        }
        $this->rating = $total / count($reviews);
    }

    //**** Контакты (ContactAssign) **********************************

    public function addContact(int $contact_id, string $value, string $description)
    {
        $contacts = $this->contactAssign;
        $contact = ContactAssign::create($contact_id, $value, $description);
        $contacts[] = $contact;
        $this->contactAssign = $contacts;
    }

    public function updateContact($contact_id, string $value, string $description)
    {
        $contacts = $this->contactAssign;
        foreach ($contacts as &$contact) {
            if ($contact->isFor($contact_id)) {
                $contact->edit($value, $description);
            }
        }
        $this->contactAssign = $contacts;
    }

    public function removeContact($contact_id)
    {
        $contacts = $this->contactAssign;
        foreach ($contacts as $i => $contact) {
            if ($contact->isFor($contact_id)) {
                unset($contacts[$i]);
                $this->contactAssign = $contacts;
                return;
            }
        }
    }

    public function getContactAssignById($contact_id): ContactAssign
    {
        $assign = $this->contactAssign;
        foreach ($assign as $item) {
            if ($item->isFor($contact_id)) return $item;
        }
        throw new DomainException('Неверный контакт');
    }

    //**** Категория (CategoryAssign) **********************************

    public function assignCategory($id): void
    {
        $assigns = $this->categoryAssign;
        foreach ($assigns as $assign) {
            if ($assign->isFor($id)) {
                return;
            }
        }
        $assigns[] = CategoryAssign::create($id);
        $this->categoryAssign = $assigns;
    }

    public function revokeCategory($id): void
    {
        $assigns = $this->categoryAssign;
        foreach ($assigns as $i => $assign) {
            if ($assign->isFor($id)) {
                unset($assigns[$i]);
                $this->categoryAssign = $assigns;
                return;
            }
        }
        throw new DomainException('Assignment is not found.');
    }

    public function clearCategory(): void
    {
        $this->categoryAssign = [];
    }

    //**** Кухня (KitchenAssign) **********************************

    public function assignKitchen($id): void
    {
        $assigns = $this->kitchenAssign;
        foreach ($assigns as $assign) {
            if ($assign->isFor($id)) {
                return;
            }
        }
        $assigns[] = KitchenAssign::create($id);
        $this->kitchenAssign = $assigns;
    }

    public function revokeKitchen($id): void
    {
        $assigns = $this->kitchenAssign;
        foreach ($assigns as $i => $assign) {
            if ($assign->isFor($id)) {
                unset($assigns[$i]);
                $this->kitchenAssign = $assigns;
                return;
            }
        }
        throw new DomainException('Assignment is not found.');
    }

    public function clearKitchen(): void
    {
        $this->kitchenAssign = [];
    }

    //**** Внешние связи **********************************

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewFood::class, ['food_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['food_id' => 'id'])->orderBy('sort');
    }

    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(InfoAddress::class, ['food_id' => 'id']);
    }

    public function getKitchenAssign(): ActiveQuery
    {
        return $this->hasMany(KitchenAssign::class, ['food_id' => 'id']);
    }

    public function getKitchens(): ActiveQuery
    {
        return $this->hasMany(Kitchen::class, ['id' => 'kitchen_id'])->via('kitchenAssign');
    }

    public function getCategoryAssign(): ActiveQuery
    {
        return $this->hasMany(CategoryAssign::class, ['food_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssign');
    }

    public function getContactAssign(): ActiveQuery
    {
        return $this->hasMany(ContactAssign::class, ['food_id' => 'id']);
    }

    public function getContacts(): ActiveQuery
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])->via('contactAssign');
    }
    public static function find(): FoodQueries
    {
        return new FoodQueries(static::class);
    }
}
