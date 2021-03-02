<?php


namespace booking\entities\booking\stays;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\hotels\rooms\Rooms;
use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\comfort\AssignComfort;
use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\comfort_room\AssignComfortRoom;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\stays\duty\AssignDuty;
use booking\entities\booking\stays\nearby\Nearby;
use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\entities\booking\stays\queries\StayQueries;
use booking\entities\booking\stays\rules\Rules;
use booking\entities\booking\BookingAddress;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use booking\helpers\SysHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Class Stays
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $legal_id
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property string $slug
 * @property integer $status
 * @property integer $main_photo_id
 * @property string $city
 * @property integer $to_center
 *
 * ====== Финансы ===================================
 * @property integer $cancellation Отмена бронирования - нет/за сколько дней
 * @property integer $check_booking - Оплата через портал или  провайдера
 * @property integer $quantity - Количество автосредств данной модели
 *
 * @property float $rating
 * @property integer $views  Кол-во просмотров
 * @property integer $public_at Дата публикации
 * @property integer $cost_base
 * @property integer $guest_base
 * @property integer $cost_add
 *
 * ====== Составные поля ===================================
 * @property StayParams $params
 * @property Type $type
 * @property Rules $rules
 * @property BookingAddress $address
 *
 * ====== дополнительно ============================================
 * @property integer $filling ... текущий раздел при заполнении
 * ====== GET-Ы ============================================
 * @property AssignComfort[] $assignComforts
 * @property AssignComfortRoom[] $assignComfortsRoom
 * @property Comfort[] $comforts
 * @property AssignRoom[] $bedrooms
 * @property Nearby[] $nearbyes
 * @property User $user
 * @property Photo $mainPhoto
 * @property Legal $legal
 * @property Photo[] $photos
 * @property ReviewStay[] $reviews
 * @property AssignDuty[] $duty
 * @property CostCalendar[] $actualCalendar
 * @property CustomServices[] $services
 *
 * @property string $adr_address [varchar(255)]
 * @property string $adr_latitude [varchar(255)]
 * @property string $adr_longitude [varchar(255)]
 * @property string $params_json [json]
 */
class Stay extends ActiveRecord
{
    const MAX_BEDROOMS = 8;
    const STAY_EMPTY = 14;

    public $address;
    public $params;

    public static function create($name, $type_id, $description, BookingAddress $address, $name_en, $description_en, $city, $to_center): self
    {
        $stays = new static();
        $stays->user_id = \Yii::$app->user->id;
        $stays->created_at = time();
        $stays->status = StatusHelper::STATUS_INACTIVE;
        $stays->name = $name;
        $stays->slug = SlugHelper::slug($name);
        $stays->type_id = $type_id;
        $stays->address = $address;
        $stays->description = $description;
        $stays->name_en = $name_en;
        $stays->description_en = $description_en;
        $stays->check_booking = BookingHelper::BOOKING_PAYMENT;
        $stays->params = new StayParams();
        $stays->rules = Rules::create();
        $stays->city = $city;
        $stays->to_center = $to_center;
        return $stays;
    }

    public function edit($name, $type_id, $description, BookingAddress $address, $name_en, $description_en, $city, $to_center): void
    {
        $this->name = $name;
        $this->type_id = $type_id;
        $this->address = $address;
        $this->description = $description;
        $this->name_en = $name_en;
        $this->description_en = $description_en;
        $this->city = $city;
        $this->to_center = $to_center;
    }

    //// AssignComfort::class ///////////////////////////

    public function getAssignComfort(int $id)
    {
        $comforts = $this->assignComforts;
        foreach ($comforts as $comfort) {
            if ($comfort->isFor($id)) return $comfort;
        }
        return null;
    }

    public function addComfort($id, $pay, UploadedFile $file = null)
    {
        $comforts = $this->assignComforts;
        $comfort = AssignComfort::create($id, $pay);
        if ($file) {
            SysHelper::orientation($file->tempName);
            $comfort->setPhoto($file);
        }
        $comforts[] = $comfort;
        $this->assignComforts = $comforts;
    }

    public function setComfort($id, $pay, UploadedFile $file = null)
    {
        $comforts = $this->assignComforts;
        foreach ($comforts as $i => $comfort) {
            if ($comfort->isFor($id)) {
                if ($file) $comfort->setPhoto($file);
                $comfort->pay = $pay;
                $this->assignComforts = $comforts;
                return;
            }
        }
        $this->addComfort($id, $pay, $file);
    }

    public function revokeComfort($id)
    {
        $comforts = $this->assignComforts;
        foreach ($comforts as $i => $comfort) {
            if ($comfort->isFor($id)) {
                unset($comforts[$i]);
                $this->assignComforts = $comforts;
                return;
            }
        }
    }

    public function revokeComforts()
    {
        $this->assignComforts = [];
    }

    public function getComfortsSortCategory(): array
    {
        $result = [];
        foreach ($this->assignComforts as $assignComfort) {
            $category = $assignComfort->comfort->category;
            $result[$category->id]['name'] = $category->name;
            $result[$category->id]['image'] = $category->image;
            $result[$category->id]['items'][] = [
                'name' => $assignComfort->comfort->name,
                'pay' => $assignComfort->pay,
                'photo' => $assignComfort->getThumbFileUrl('file', 'thumb')
            ];
        }
        return $result;
    }

    //// AssignComfortRoom::class ///////////////////////////

    public function getAssignComfortRoom(int $id)
    {
        $comforts = $this->assignComfortsRoom;
        foreach ($comforts as $comfort) {
            if ($comfort->isFor($id)) return $comfort;
        }
        return null;
    }

    public function addComfortRoom($id, UploadedFile $file = null)
    {
        $comforts = $this->assignComfortsRoom;
        $comfort = AssignComfortRoom::create($id);
        if ($file) {
            SysHelper::orientation($file->tempName);
            $comfort->setPhoto($file);
        }
        $comforts[] = $comfort;
        $this->assignComfortsRoom = $comforts;
    }

    public function setComfortRoom($id, UploadedFile $file = null)
    {
        $comforts = $this->assignComfortsRoom;
        foreach ($comforts as $i => $comfort) {
            if ($comfort->isFor($id)) {
                if ($file) $comfort->setPhoto($file);
                $this->assignComfortsRoom = $comforts;
                return;
            }
        }
        $this->addComfortRoom($id, $file);
    }

    public function revokeComfortRoom($id)
    {
        $comforts = $this->assignComfortsRoom;
        foreach ($comforts as $i => $comfort) {
            if ($comfort->isFor($id)) {
                unset($comforts[$i]);
                $this->assignComfortsRoom = $comforts;
                return;
            }
        }
    }
    public function revokeComfortsRoom()
    {
        $this->assignComfortsRoom = [];
    }

    public function getComfortsRoomSortCategory(): array
    {
        $result = [];
        foreach ($this->assignComfortsRoom as $assignComfort) {
            $category = $assignComfort->comfortRoom->category;
            if ($assignComfort->comfortRoom->featured) {
                $result[0]['name'] = 'Популярные удобства';
                $result[0]['image'] = '';
                $result[0]['items'][] = [
                    'name' => $assignComfort->comfortRoom->name,
                    'photo' => $assignComfort->getThumbFileUrl('file', 'thumb')
                ];
            } else {
                $result[$category->id]['name'] = $category->name;
                $result[$category->id]['image'] = $category->image;
                $result[$category->id]['items'][] = [
                    'name' => $assignComfort->comfortRoom->name,
                    'photo' => $assignComfort->getThumbFileUrl('file', 'thumb')
                ];
            }
        }
        return $result;
    }

    public function getNearbySortCategory(): array
    {
        $result = [];
        foreach ($this->nearbyes as $nearby) {
            $category = $nearby->category;
            //$result[$category->group]['name'] = NearbyCategory::listGroup()[$category->group];
            $result[$category->group][$category->name][] = ['name' => $nearby->name, 'distance' => $nearby->distance, 'unit' => $nearby->unit];
        }
        //scr::p($result);
        return $result;
    }

    ////////////////////////////////

    /// DUTY //////////////

    public function addDuty($duty_id, $value, $payment, $include)
    {
        $duty = $this->duty;
        /*foreach ($duty as $assignDuty) {
            if ($assignDuty->isFor($duty_id)) return;
        } */
        $duty[] = AssignDuty::create($duty_id, $value, $payment, $include);
        $this->duty = $duty;
    }

    public function removeDuty($duty_id)
    {
        $duty = $this->duty;
        foreach ($duty as $i => $assignDuty) {
            if ($assignDuty->isFor($duty_id)) {
                unset($duty[$i]);
                $this->duty = $duty;
                return;
            }
        }
        throw new \DomainException('Сбор не найден');
    }

    public function clearDuty()
    {
        $this->duty = [];
    }

    public function getDutyById(int $id)
    {
        foreach ($this->duty as $assignDuty) {
            if ($assignDuty->isFor($id)) return $assignDuty;
        }
        return null;
    }
    ////////////////////////////////

   ///////////////// SERVICES /////////////////////////////////////

    public function getServicesById(int $id)
    {
        foreach ($this->services as $customServices) {
            if ($customServices->isFor($id)) return $customServices;
        }
        return null;
    }

    public function addServices($name, $value, $payment)
    {
        $services = $this->services;
        $services[] = CustomServices::create($name, $value, $payment);

        $this->services = $services;

    }

    public function clearServices()
    {
        $this->services = [];
    }
    ////////////////////////////////

    public function setLegal($legalId): void
    {
        $this->legal_id = $legalId;
    }

    public function updateRules(Rules $rules)
    {
        $this->rules = $rules;
    }

    public function setParams(StayParams $params)
    {
        $this->params = $params;
    }
/*
    public function setCost($cost)
    {
        $this->cost = $cost;
    }
*/
    public function setCancellation($cancellation)
    {
        $this->cancellation = $cancellation;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setCheckBooking($check_booking)
    {
        $this->check_booking = $check_booking;
    }

    public function isConfirmation(): bool
    {
        return $this->check_booking == BookingHelper::BOOKING_CONFIRMATION;
    }

    public function isActive(): bool
    {
        return $this->status === StatusHelper::STATUS_ACTIVE;
    }

    public function isVerify(): bool
    {
        return $this->status === StatusHelper::STATUS_VERIFY;
    }

    public function isDraft(): bool
    {
        return $this->status === StatusHelper::STATUS_DRAFT;
    }

    public function isInactive(): bool
    {
        return $this->status === StatusHelper::STATUS_INACTIVE;
    }

    public function isLock()
    {
        return $this->status === StatusHelper::STATUS_LOCK;
    }

    public function isCancellation($date_tour)
    {
        if ($this->cancellation == null) return false;
        if ($date_tour <= time()) return false;
        if (($date_tour - time()) / (24 * 3600) < $this->cancellation) return false;
        return true;
    }

    public function upViews(): void
    {
        $this->views++;
    }

    public function isNew(): bool
    {
        if ($this->public_at == null) return false;
        return (time() - $this->public_at) / (3600 * 24) < BookingHelper::NEW_DAYS;
    }

    public function getMaxGuest(): int
    {
        $count = 0;
        $bedrooms = $this->bedrooms;
        foreach ($bedrooms as $bedroom) {
            $count += $bedroom->getCounts();
        }
        return $count;
    }

    public static function tableName()
    {
        return '{{%booking_stays}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                    'rules',
                    'reviews',
                    'nearbyes',
                    'assignComforts',
                    'assignComfortsRoom',
                    'bedrooms',
                    'duty',
                    'actualCalendar',
                    'services',
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

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_address'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );
        $params = Json::decode($this->getAttribute('params_json'), true);
        $this->params = new StayParams(
            $params['params_square'] ?? null,
            $params['params_count_bath'] ?? null,
            $params['params_count_kitchen'] ?? null,
            $params['params_count_floor'] ?? null,
            $params['params_guest'] ?? null,
            $params['params_deposit'] ?? null,
            $params['params_access'] ?? null
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('adr_address', $this->address->address);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);

        $this->setAttribute('params_json', Json::encode([
            'params_square' => $this->params->square,
            'params_count_bath' => $this->params->count_bath,
            'params_count_kitchen' => $this->params->count_kitchen,
            'params_count_floor' => $this->params->count_floor,
            'params_guest' => $this->params->guest,
            'params_deposit' => $this->params->deposit,
            'params_access' => $this->params->access,
        ]));
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

    /** Nearby  ==========>*/

    public function addNearby($name, $distance, $category_id, $unit)
    {
        $nearbyes = $this->nearbyes;
        $nearbyes[] = Nearby::create($name, $distance, $category_id, $unit);
        $this->nearbyes = $nearbyes;
    }

    public function removeNearby($id)
    {
        $nearbyes = $this->nearbyes;
        foreach ($nearbyes as $i => $nearby) {
            if ($nearby->isFor($id)) {
                unset($nearbyes[$i]);
                $this->nearbyes = $nearbyes;
                return;
            }
        }
        throw new \DomainException('Не найдено Расположение');
    }

    public function clearNearby()
    {
        $this->nearbyes = [];
    }
    /** <==========  Nearby  */


    /** Review  ==========>*/

    public function addReview($userId, $vote, $text): ReviewStay
    {
        $reviews = $this->reviews;
        $review = ReviewStay::create($userId, $vote, $text);
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

    private function updateReviews(array $reviews): void
    {
        $total = 0;
        /* @var ReviewStay $review */
        foreach ($reviews as $review) {
                $total += $review->getRating();
        }
        $this->reviews = $reviews;
        $this->rating = $total / count($reviews);
    }

    /** <==========  Reviews  */

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

    public function addCostCalendar($stay_at, $cost_base, $guest_base, $cost_add)
    {
        $calendar = CostCalendar::create($stay_at, $cost_base, $guest_base, $cost_add);
        $calendars = $this->actualCalendar;
        $calendars[] = $calendar;
        $this->actualCalendar = $calendars;
        //TODO !!!!

    }

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }

    /** getXXX ==========> */
    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewStay::class, ['stay_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['stay_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getRules(): ActiveQuery
    {
        return $this->hasOne(Rules::class, ['stay_id' => 'id']);
    }

    public function getAssignComforts(): ActiveQuery
    {
        return $this->hasMany(AssignComfort::class, ['stay_id' => 'id']);
    }

    public function getAssignComfortsRoom(): ActiveQuery
    {
        return $this->hasMany(AssignComfortRoom::class, ['stay_id' => 'id']);
    }

    public function getComforts(): ActiveQuery
    {
        return $this->hasMany(Comfort::class, ['id' => 'comfort_id'])->via('assignComforts');
    }

    public function getComfortsRoom(): ActiveQuery
    {
        return $this->hasMany(ComfortRoom::class, ['id' => 'comfort_id'])->via('assignComfortsRoom');
    }

    public function getNearbyes(): ActiveQuery
    {
        return $this->hasMany(Nearby::class, ['stay_id' => 'id']);
    }

    public function getDuty(): ActiveQuery
    {
        return $this->hasMany(AssignDuty::class, ['stay_id' => 'id']);
    }

    public function getNearbyByCategory($category)
    {
        //TODO ?? Куда впихнуть???
        return Nearby::find()->andWhere(['stay_id' => $this->id])->andWhere(['category_id' => $category])->all();
    }

    public function getBedrooms(): ActiveQuery
    {
        return $this->hasMany(AssignRoom::class, ['stay_id' => 'id']);
    }

    public function getActualCalendar(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['stay_id' => 'id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasMany(CustomServices::class, ['stay_id' => 'id']);
    }



    /** <========== getXXX */

    public static function find(): StayQueries
    {
        return new StayQueries(static::class);
    }
}