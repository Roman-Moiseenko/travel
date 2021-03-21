<?php


namespace booking\entities\booking\stays;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\behaviors\MetaBehavior;
use booking\entities\booking\BaseObjectOfBooking;
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
use booking\entities\Meta;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\helpers\SlugHelper;
use booking\helpers\StatusHelper;
use booking\helpers\SysHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Class Stays
 * @package booking\entities\booking\stays
 * Общие параметры *****************************
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
 * @property float $rating
 * @property integer $views  Кол-во просмотров
 * @property integer $public_at Дата публикации
 * @property Meta $meta
 * @property BookingAddress $address
 * ====== Финансы ===================================
 * @property integer $cancellation Отмена бронирования - нет/за сколько дней
 * @property integer $quantity - Количество автосредств данной модели
 * @property integer $prepay

 * @property integer $filling ... текущий раздел при заполнении
 *
 *
 * Специфические параметры
 * @property string $city
 * @property integer $to_center
 *
 *

 *

 * @property integer $cost_base
 * @property integer $guest_base
 * @property integer $cost_add
 *
 * ====== Составные поля ===================================
 * @property StayParams $params
 * @property Type $type
 * @property Rules $rules


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
 * //__property CostCalendar[] $calendarRange
 * @property CustomServices[] $services
 *
 * @property string $adr_address [varchar(255)]
 * @property string $adr_latitude [varchar(255)]
 * @property string $adr_longitude [varchar(255)]
 * @property int $params_square [int]
 * @property int $params_count_bath [int]
 * @property int $params_count_kitchen [int]
 * @property int $params_count_floor [int]
 * @property int $params_guest [int]
 * @property int $params_deposit [int]
 * @property int $params_access [int]
 * @property string $meta_json
 */
class Stay extends BaseObjectOfBooking
{
    const MAX_BEDROOMS = 8;

    const ERROR_NOT_FREE = -10;
    const ERROR_NOT_DATE = -20;
    const ERROR_NOT_CHILD = -30;
    const ERROR_NOT_DATE_END = -40;
    const ERROR_NOT_GUEST = -50;
    const ERROR_NOT_CHILD_AGE = -60;
    const ERROR_LIMIT_CHILD_AGE = -70;

    /** @var $address BookingAddress */
    public $address;
    /** @var $params StayParams */
    public $params;


    public static function listErrors(): array
    {
        return [
            self::ERROR_NOT_FREE => Lang::t('На выбранные даты нет свободных мест'),
            self::ERROR_NOT_DATE => Lang::t('Укажите даты для расчета стоимости'),
            self::ERROR_NOT_CHILD => Lang::t('Не предусмотрено с детьми'),
            self::ERROR_NOT_DATE_END => Lang::t('Неверная дата отъезда'),
            self::ERROR_NOT_GUEST => Lang::t('Превышено количество гостей'),
            self::ERROR_NOT_CHILD_AGE => Lang::t('Не указан возраст детей'),
            self::ERROR_LIMIT_CHILD_AGE => Lang::t('Ограничение по возрасту ребенка'),
        ];
    }

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
        $stays->params = new StayParams();
        $stays->rules = Rules::create();
        $stays->meta = new Meta();
        $stays->city = $city;
        $stays->to_center = $to_center;
        $stays->prepay = 100;
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
                'pay' => $assignComfort->comfort->paid == true ? $assignComfort->pay : null,
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

    public function getComfortsRoomSortCategoryFrontend(): array
    {
        $result = [];
        foreach ($this->assignComfortsRoom as $assignComfort) {
            $category = $assignComfort->comfortRoom->category;
            $result[$category->id]['name'] = $category->name;
            $result[$category->id]['image'] = $category->image;
            $result[$category->id]['items'][] = [
                'name' => $assignComfort->comfortRoom->name,
                'photo' => $assignComfort->getThumbFileUrl('file', 'thumb')
            ];
        }
        return $result;
    }

    public function getNearbySortCategory(): array
    {
        $result = [];
        foreach ($this->nearbyes as $nearby) {
            $category = $nearby->category;
            $result[$category->group][$category->name][] = ['name' => $nearby->name, 'distance' => $nearby->distance, 'unit' => $nearby->unit];
        }
        return $result;
    }

    ////////////////////////////////

    /// DUTY //////////////

    public function addDuty($duty_id, $value, $payment, $include)
    {
        $duty = $this->duty;
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


    public function updateRules(Rules $rules)
    {
        $this->rules = $rules;
    }

    public function setParams(StayParams $params)
    {
        $this->params = $params;
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
        $relations = [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'rules',
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
        return array_merge($relations, parent::behaviors());
    }

    public function afterFind(): void
    {
        $this->address = new BookingAddress(
            $this->getAttribute('adr_address'),
            $this->getAttribute('adr_latitude'),
            $this->getAttribute('adr_longitude')
        );
        $this->params = new StayParams(
            $this->getAttribute('params_square'),
            $this->getAttribute('params_count_bath'),
            $this->getAttribute('params_count_kitchen'),
            $this->getAttribute('params_count_floor'),
            $this->getAttribute('params_guest'),
            $this->getAttribute('params_deposit'),
            $this->getAttribute('params_access')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('adr_address', $this->address->address);
        $this->setAttribute('adr_latitude', $this->address->latitude);
        $this->setAttribute('adr_longitude', $this->address->longitude);

        $this->setAttribute('params_square', $this->params->square);
        $this->setAttribute('params_count_bath', $this->params->count_bath);
        $this->setAttribute('params_count_kitchen', $this->params->count_kitchen);
        $this->setAttribute('params_count_floor', $this->params->count_floor);
        $this->setAttribute('params_guest', $this->params->guest);
        $this->setAttribute('params_deposit', $this->params->deposit);
        $this->setAttribute('params_access', $this->params->access);
        return parent::beforeSave($insert);
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

/*
    public function addCostCalendar($stay_at, $cost_base, $guest_base, $cost_add)
    {
        $calendar = CostCalendar::create($stay_at, $cost_base, $guest_base, $cost_add);
        $calendars = $this->actualCalendar;
        $calendars[] = $calendar;
        $this->actualCalendar = $calendars;


    }*/

    /** getXXX ==========> */
    public function getType(): ActiveQuery
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
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

    public function getCalendarRange($date_begin, $date_end): array
    {
        return CostCalendar::find()->andWhere(['stay_id' => $this->id])->andWhere(['>=', 'stay_at', $date_begin])->andWhere(['<=', 'stay_at', $date_end])->orderBy('stay_at')->all();
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

    public function costBySearchParams(array $params)
    {
        if (empty($params)) return $this->cost_base;
        $guest = (int)$params['guest'];
        $children = (int)$params['children'];
        $children_age = $params['children_age'];
        if ($children > 0) {
            $n = $children;
            for($i = 0; $i < $n; $i ++) {
                if ($children_age[$i] >= $this->rules->beds->child_by_adult) {$guest++; $children--;}
            }
            if ($children > round($guest / 2))  {
                $guest += round(($children - round($guest / 2)) / 2);
            }
        }
        if (empty($params['date_from'])) {
            $add_guest = ($guest > $this->guest_base) ? ($guest - $this->guest_base) : 0;
            return $this->cost_base + $add_guest * $this->cost_add;
        }

        $begin = SysHelper::_renderDate($params['date_from']);
        $end = SysHelper::_renderDate($params['date_to']);
        $days = round(($end - $begin) / (24 * 60 * 60));
        $cost = 0;
        $calendars = CostCalendar::find()
            ->andWhere(['stay_id' => $this->id])
            ->andWhere(['>=', 'stay_at', $begin])
            ->andWhere(['<=', 'stay_at', $end - 24 * 60 * 60])
            ->orderBy('stay_at')->all();
        if ($days != count($calendars)) {
            return self::ERROR_NOT_FREE;
        }
        foreach ($calendars as $calendar) {
            $add_guest = ($guest > $calendar->guest_base) ? ($guest - $calendar->guest_base) : 0;
            $cost += $calendar->cost_base + $add_guest * $calendar->cost_add;
        }
        $cost_service = 0;
        //$guest = $params['guest'];
        if (isset($params['services']))
            foreach ($params['services'] as $service_id) {
                if ($service_id != "") {
                    $service = $this->getServicesById((int)$service_id);
                    switch ($service->payment) {
                        case CustomServices::PAYMENT_PERCENT :
                            $cost_service += $cost * ($service->value / 100);
                            break;
                        case CustomServices::PAYMENT_FIX_DAY:
                            $cost_service += $service->value * $days;
                            break;
                        case CustomServices::PAYMENT_FIX_ALL:
                            $cost_service += $service->value;
                            break;
                        case CustomServices::PAYMENT_FIX_DAY_GUEST:
                            $cost_service += $service->value * $days * $guest;
                            break;
                        case CustomServices::PAYMENT_FIX_ALL_GUEST:
                            $cost_service += $service->value * $guest;
                            break;
                        default:
                            $cost_service += 0;
                    }
                }
            }
        return $cost + $cost_service;
    }

    public function checkBySearchParams(array $params)
    {
        //Проверка на даты
        if ($params['date_from'] && $params['date_to']) {
            $begin = SysHelper::_renderDate($params['date_from']);
            $end = SysHelper::_renderDate($params['date_to']);
            $days = round(($end - $begin) / (24 * 60 * 60));
            if ($days <= 0) return Stay::ERROR_NOT_DATE_END;
            $calendars = CostCalendar::find()
                ->andWhere(['stay_id' => $this->id])
                ->andWhere(['>=', 'stay_at', $begin])
                ->andWhere(['<=', 'stay_at', $end - 24 * 60 * 60])
                ->count('id');
            if ($days != $calendars) {
                return Stay::ERROR_NOT_FREE;
            }
        } else {
            return Stay::ERROR_NOT_DATE;
        }

        //Проверка на детей
        $children = (int)$params['children'];
        $children_age = $params['children_age'];
        $guest = (int)$params['guest'];
        if ($children > 0) {
            if (!$this->rules->limit->children) return self::ERROR_NOT_CHILD;
            $min_age = 16;
            for ($i = 0; $i < $children; $i++) {
                if ($children_age[$i] == "") return self::ERROR_NOT_CHILD_AGE;
                $min_age = min($min_age, (int)$children_age[$i]);
                if ($children_age[$i] >= $this->rules->beds->child_by_adult) {$guest++;}
            }
            if ($guest > $this->params->guest) return self::ERROR_NOT_GUEST;
            if ($min_age < $this->rules->limit->children_allow) return self::ERROR_LIMIT_CHILD_AGE;
        }
        return true;
    }
}