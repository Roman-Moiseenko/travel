<?php


namespace booking\entities\vmuseum;


use booking\entities\admin\Contact;
use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\behaviors\WorkModeBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\Fun;
use booking\entities\vmuseum\exhibit\Exhibit;
use booking\entities\WorkMode;
use booking\entities\Meta;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class VMuseum
 * @package booking\entities\vmuseum
 * @property integer $id
 * @property integer $fun_id
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
 * @property AssignTour[] $assignTour
 * @property ReviewVMuseum[] $reviews
 * @property Hall[] $halls
 * @property Fun $fun
 * @property int $main_photo_id [int]
 * @property string $meta_json [json]
 * @property string $work_mode_json [json]
 * @property string $address_address [varchar(255)]
 * @property string $address_latitude [varchar(255)]
 * @property string $address_longitude [varchar(255)]
 */


class VMuseum extends ActiveRecord
{
    /** @var WorkMode[] $workModes */
    public $workModes = [];
    /** @var $meta Meta */
    public $meta;
    /** @var $address BookingAddress */
    public $address;

    public static function create($name, $name_en, $description, $description_en, $slug, $fun_id): self
    {
        $vmuseum = new static();
        $vmuseum->name = $name;
        $vmuseum->name_en = $name_en;
        $vmuseum->slug = empty($slug) ? SlugHelper::slug($name) : $slug;
        $vmuseum->description = $description;
        $vmuseum->description_en = $description_en;
        $vmuseum->fun_id = $fun_id;
        $vmuseum->status = StatusHelper::STATUS_INACTIVE;
        $vmuseum->created_at = time();
        return $vmuseum;
    }

    public function edit($name, $name_en, $description, $description_en, $slug, $fun_id): void
    {
        $this->name = $name;
        if ($this->slug != $slug) $this->slug = $slug;
        $this->name_en = $name_en;
        $this->description = $description;
        $this->description_en = $description_en;
        $this->fun_id = $fun_id;
    }

    public function activate(): void
    {
        $this->status = StatusHelper::STATUS_ACTIVE;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setAddress(BookingAddress $address): void
    {
        $this->address = $address;
    }

    public function setWorkMode(array $workModes): void
    {
        $this->workModes = $workModes;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function tableName()
    {
        return '{{%vmuseum}}';
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

    public function getAssignTour(): ActiveQuery
    {
        return $this->hasMany(AssignTour::class, ['vmuseum_id' => 'id']);
    }

    public function getContactAssign(): ActiveQuery
    {
        return $this->hasMany(ContactAssign::class, ['shop_id' => 'id']);
    }

    public function getContacts(): ActiveQuery
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])->via('contactAssign');
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewVMuseum::class, ['vmuseum_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['shop_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getFun(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
    }

    public function getHalls(): ActiveQuery
    {
        return $this->hasMany(Hall::class, ['vmuseum_id' => 'id']);
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