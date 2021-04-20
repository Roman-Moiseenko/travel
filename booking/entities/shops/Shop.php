<?php


namespace booking\entities\shops;


use booking\ActivateObjectInterface;
use booking\entities\admin\Contact;
use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BasePhoto;
use booking\entities\booking\BaseReview;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\WorkMode;
use booking\entities\Lang;
use booking\entities\Meta;
use booking\entities\office\PriceInterface;
use booking\entities\queries\ObjectActiveQuery;
use booking\entities\shops\products\Product;
use booking\forms\shops\DeliveryForm;
use booking\helpers\BookingHelper;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Shop
 * @package booking\entities\shops
 * @property integer $id
 * @property bool $ad -- онлайн или витрина
 * @property integer $user_id
 * @property integer $legal_id
 * @property integer $public_at
 * @property int $type_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property float $rating
 * @property integer $status
 ********************************* Внешние связи
 * @property Product[] $products
 * @property User $user
 * @property Legal $legal
 * @property integer $views
 * @property string $slug
 *
 * @property InfoAddress[] $addresses
 * @property Photo $mainPhoto
 * @property Photo[] $photos
 * @property Contact[] $contacts
 * @property ContactAssign[] $contactAssign
 * @property ReviewShop[] $reviews
 * @property Product[] $activeProducts
 * @property Delivery $delivery
 *
 * @property integer $main_photo_id
 * @property integer $free_products
 * @property integer $active_products
 *
 *********************************** Скрытые поля
 * @property string $work_mode_json
 * @property string $delivery_json
 * @property string $meta_json
 */
class Shop extends ActiveRecord implements ActivateObjectInterface, PriceInterface
{
    /** @var WorkMode[] $workModes */
    public $workModes = [];
    /** @var Meta $meta */
    public $meta;
    /** @var $_delivery Delivery */
    private $_delivery;

    public static function create($user_id, $legal_id, $name, $name_en, $description, $description_en, $type_id, $ad): Shop
    {
        $shop = new static();
        $shop->ad = $ad;
        $shop->created_at = time();
        $shop->user_id = $user_id;
        $shop->legal_id = $legal_id;
        $shop->name = $name;
        $shop->name_en = $name_en;
        $shop->description = $description;
        $shop->description_en = $description_en;
        $shop->type_id = $type_id;

        $shop->status = StatusHelper::STATUS_INACTIVE;
        $shop->meta = new Meta();
        $shop->slug = SlugHelper::slug($name);
        if (Shop::find()->andWhere(['slug' => $name])->one()) $shop->slug .= '-' . $shop->user_id;
        $shop->views = 0;

        for ($i = 0; $i < 7; $i++) {
            $shop->workModes[] = new WorkMode();
        }
        //$shop->delivery = new Delivery();
        return $shop;
    }

    public function edit($legal_id, $name, $name_en, $description, $description_en, $type_id, $ad): void
    {
        $this->ad = $ad;
        $this->legal_id = $legal_id;
        $this->name = $name;
        $this->name_en = $name_en;
        $this->description = $description;
        $this->description_en = $description_en;
        $this->type_id = $type_id;
    }

    public function setDelivery(DeliveryForm $form): void
    {
        if ($this->ad) throw new \DomainException('Нельзя установить Доставку для Витрины');

        $this->_delivery = Delivery::create(
            $form->onCity,
            $form->costCity,
            $form->minAmountCity,
            $form->minAmountCompany,
            $form->period,
            $form->onPoint,
            new BookingAddress(
                $form->addressPoint->address,
                $form->addressPoint->latitude,
                $form->addressPoint->longitude
            )
        );
        foreach ($form->deliveryCompany as $item) {
            $this->_delivery->addCompany($item);
        }

    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setWorkMode(array $workModes): void
    {
        $this->workModes = $workModes;
    }

    public function isAd(): bool
    {
        return $this->ad;
    }

    //**************** Set ****************************

    public function setStatus($status)
    {
        $this->status = $status;
    }

    //**************** Get ****************************

    final public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    final public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    //**************** is ****************************
    final public function isNew(): bool
    {
        if ($this->created_at == null) return false;
        return (time() - $this->created_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

    final public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    final public function isVerify(): bool
    {
        return $this->status === StatusHelper::STATUS_VERIFY;
    }

    final public function isDraft(): bool
    {
        return $this->status === StatusHelper::STATUS_DRAFT;
    }

    final public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_INACTIVE;
    }

    final public function isLock()
    {
        return $this->status === StatusHelper::STATUS_LOCK;
    }

    public static function tableName()
    {
        return '{{%shops}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterFind(): void
    {
        $delivery = Json::decode($this->getAttribute('delivery_json'));
        /*
        $this->delivery = Delivery::create(
            $delivery['onCity'] ?? null,
            $delivery['costCity'] ?? null,
            $delivery['minAmountCity'] ?? null,
            $delivery['minAmountCompany'] ?? null,
            $delivery['period'] ?? null,
            $delivery['deliveryCompany'] ?? [],
            $delivery['onPoint'] ?? null,
            new BookingAddress(
                $delivery['addressPoint']['address'] ?? null,
                $delivery['addressPoint']['latitude'] ?? null,
                $delivery['addressPoint']['longitude'] ?? null
            )
        );
*/
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

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        /*
        $delivery = $this->delivery;
        $this->setAttribute('delivery_json', Json::encode([
            'onCity' => $delivery->onCity,
            'costCity' => $delivery->costCity,
            'minAmountCity' => $delivery->minAmountCity,
            'minAmountCompany' => $delivery->minAmountCompany,
            'period' => $delivery->period,
            'deliveryCompany' => $delivery->deliveryCompany,
            'onPoint' => $delivery->onPoint,
            'addressPoint' => [
                'address' => $delivery->addressPoint->address,
                'latitude' => $delivery->addressPoint->latitude,
                'longitude' => $delivery->addressPoint->longitude,
            ],
        ]));
        */
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
        //TODO Сохраняем Delivery
        $this->saveDelivery();
    }

    //**** Адреса (InfoAddress) **********************************

    public function addAddress(InfoAddress $address)
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

    //****** Внешние связи ****************************

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['shop_id' => 'id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
    }

    public function getActiveProducts(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['shop_id' => 'id'])->andWhere([Product::tableName() . '.active' => true]);
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
        return $this->hasMany(ReviewShop::class, ['shop_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['shop_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(InfoAddress::class, ['shop_id' => 'id']);
    }

    public function getDelivery(): ActiveQuery
    {
        return $this->hasOne(Delivery::class, ['shop_id' => 'id']);
    }


    public function contactAssignById(int $id): ?ContactAssign
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

    public static function find(): ObjectActiveQuery
    {
        return new ObjectActiveQuery(static::class);
    }

    private function saveDelivery(): void
    {
        if (!$this->ad) {
            if ($this->_delivery == null) {
                if ($this->delivery == null) throw new \DomainException('Не определен параметр _delivery');
            } else {
                if ($this->delivery != null) {
                    $delivery = $this->delivery;
                    $delivery->edit(
                        $this->_delivery->onCity,
                        $this->_delivery->costCity,
                        $this->_delivery->minAmountCity,
                        $this->_delivery->minAmountCompany,
                        $this->_delivery->period,
                        $this->_delivery->onPoint,
                        $this->_delivery->addressPoint
                    );
                    $delivery->clearCompany();
                    $delivery->save();
                    foreach ($this->_delivery->companiesAssign as $assign) {
                        $delivery->addCompany($assign->delivery_company_id);
                    }
                    $delivery->save();
                } else {
                    $this->_delivery->shop_id = $this->id;
                    $this->_delivery->save();
                }

            }
        } else {
            if ($this->delivery != null) {
                $delivery = $this->delivery;
                $delivery->delete();
            }
        }

    }
}