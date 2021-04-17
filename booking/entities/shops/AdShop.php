<?php


namespace booking\entities\shops;

use booking\entities\admin\Contact;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\booking\funs\WorkMode;
use booking\entities\Meta;
use booking\entities\office\PriceInterface;
use booking\entities\shops\products\AdProduct;
use booking\helpers\SlugHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class AdShop
 * @package booking\entities\shops
 * @property integer $main_photo_id
 * @property string $slug
 *
 * @property AdInfoAddress[] $addresses
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property Contact[] $contacts
 * @property AdContactAssign[] $contactAssign
 * @property AdReviewShop[] $reviews
 * @property AdProduct[] $products
 * @property AdProduct[] $activeProducts
 * @property string $work_mode_json
 *
 * @property integer $free_products
 * @property integer $active_products
 *
 * @property Meta $meta
 * @property string $meta_json
 * @property int $views [int]
 */
class AdShop extends BaseShop implements PriceInterface
{
    /** @var WorkMode[] $workModes */
    public $workModes = [];
    /** @var Meta $meta */
    public $meta;


    public static function create($user_id, $legal_id, $name, $name_en, $description, $description_en, $type_id): self
    {
        $shop = new static($user_id, $legal_id, $name, $name_en, $description, $description_en, $type_id);
        $shop->meta = new Meta();
        $shop->slug = empty($slug) ? SlugHelper::slug($shop->name) : $slug;
        if (AdShop::find()->andWhere(['slug' => $shop->slug])->one()) $shop->slug .= '-' . $shop->user_id;
        for ($i = 0; $i < 7; $i++) {
            $shop->workModes[] = new WorkMode();
        }
        return $shop;
    }

    public function isAd(): bool
    {
        return true;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setWorkMode(array $workModes): void
    {
        $this->workModes = $workModes;
    }

    public static function tableName()
    {
        return '{{%shops_ad}}';
    }

    public function behaviors()
    {
        $result = parent::behaviors();
        $new_behaviors = [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'contactAssign',
                    'addresses',
                    'reviews',
                ],
            ],

        ];
        return array_merge($result, $new_behaviors);
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

    public function addAddress(AdInfoAddress $address)
    {
        $addresses = $this->addresses;
        $addresses[] = $address;
        $this->addresses = $addresses;
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
        $contact = AdContactAssign::create($contact_id, $value, $description);
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

    //****** Внешние связи *****

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(AdProduct::class, ['shop_id' => 'id']);
    }

    public function getActiveProducts(): ActiveQuery
    {
        return $this->hasMany(AdProduct::class, ['shop_id' => 'id'])->andWhere([AdProduct::tableName() . '.active' => true]);
    }

    public function getContactAssign(): ActiveQuery
    {
        return $this->hasMany(AdContactAssign::class, ['shop_id' => 'id']);
    }

    public function getContacts(): ActiveQuery
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])->via('contactAssign');
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(AdReviewShop::class, ['shop_id' => 'id']);
    }

    public function getPhotos():ActiveQuery
    {
        return $this->hasMany(Photo::class, ['shop_id' => 'id']);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(AdInfoAddress::class, ['shop_id' => 'id']);
    }

    public function contactAssignById(int $id):? AdContactAssign
    {
        $contacts = $this->contactAssign;
        foreach ($contacts as $contact) {
            if ($contact->isFor($id)) return $contact;
        }
        return null;
    }

    public function activePlace(): int
    {
       return count($this->activeProducts);
    }

    public function setActivePlace($count): void
    {
        $this->active_products = $count;
    }

    public function countActivePlace(): int
    {
        return $this->active_products;
    }
}