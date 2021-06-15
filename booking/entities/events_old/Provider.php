<?php


namespace booking\entities\events;


use booking\entities\admin\Contact;
use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\behaviors\WorkModeBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\WorkMode;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Provider
 * @package booking\entities\event
 * @property integer $id
 * @property integer $fun_id может принимать значение null
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property string $slug
 * @property float $rating
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property ContactAssign[] $contactAssign
 * @property Contact[] $contacts
 * @property ReviewProvider[] $reviews
 * @property string
 *
 */
class Provider extends ActiveRecord
{
    /** @var WorkMode[] $workModes */
    public $workModes = [];
    /** @var $meta Meta */
    public $meta;
    /** @var $address BookingAddress */
    public $address;

    public static function create($name, $name_en, $description, $description_en, $slug, $fun_id): self
    {
        $provider = new static();
        $provider->name = $name;
        $provider->name_en = $name_en;
        $provider->description = $description;
        $provider->description_en = $description_en;
        $provider->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $provider->fun_id = $fun_id;
        $provider->created_at = time();
        $provider->status = StatusHelper::STATUS_INACTIVE;
        return $provider;
    }

    public function edit($name, $name_en, $description, $description_en, $slug, $fun_id): void
    {
        $this->name = $name;
        $this->name_en = $name_en;
        $this->description = $description;
        $this->description_en = $description_en;
        if (!empty($slug) && $this->slug != $slug) $this->slug = $slug;
        $this->fun_id = $fun_id;
        $this->updated_at = time();
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function activate(): void
    {
        $this->status = StatusHelper::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        $this->status = StatusHelper::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == StatusHelper::STATUS_ACTIVE;
    }

    public function setAddress(BookingAddress $address): void
    {
        $this->address = $address;
    }

    public function setWorkMode(array $workModes): void
    {
        $this->workModes = $workModes;
    }

    public static function tableName()
    {
        return '{{%event_provider}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            WorkModeBehavior::class,
            BookingAddressBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'contactAssign',
                    'reviews',
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

    //**** Контакты (ContactAssign) **********************************

    public function addContact(int $contact_id, string $value, string $description)
    {
        $contacts = $this->contactAssign;
        $contact = ContactAssign::create($contact_id, $value, $description);
        $contacts[] = $contact;
        $this->contactAssign = $contacts;
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

    public function getContactAssign(): ActiveQuery
    {
        return $this->hasMany(ContactAssign::class, ['provider_id' => 'id']);
    }

    public function getContacts(): ActiveQuery
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])->via('contactAssign');
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewProvider::class, ['provider_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['shop_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function contactAssignById(int $id): ?ContactAssign
    {
        $contacts = $this->contactAssign;
        foreach ($contacts as $contact) {
            if ($contact->isFor($id)) return $contact;
        }
        return null;
    }
}