<?php


namespace booking\entities\shops;


use booking\entities\BaseInfoAddress;
use booking\entities\booking\BookingAddress;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Delivery
 * @package booking\entities\shops
 *
 * @property DeliveryCompanyAssign[] $companiesAssign
 * @property DeliveryCompany[] $companies
 * @property int $id [int]
 * @property int $shop_id [int]
 * @property string $address [varchar(255)]
 * @property string $latitude [varchar(255)]
 * @property string $longitude [varchar(255)]
 * @property bool $onCity [tinyint(1)]
 * @property int $costCity [int]
 * @property int $minAmountCity [int]
 * @property int $minAmountCompany [int]
 * @property int $period [int]
 * @property bool $onPoint [tinyint(1)]
 */
class Delivery extends ActiveRecord
{
   /* public $onCity; //Есть ли доставка по городу
    public $costCity; //Стоимость доставки
    public $minAmountCity; //Мин.Сумма для доставки по городу
    public $minAmountCompany; //минимальная сумма для доставки ТК
    public $period; //0 - по заказу, 1..7 - сколько раз в неделю
    public $deliveryCompany = []; //транспортные компании
    public $onPoint; //есть ли выдача в городе
    /** @var $addressPoint BookingAddress */
    public $addressPoint; //адрес откуда можно забрать после оплаты ??

    public static function create($onCity, $costCity, $minAmountCity, $minAmountCompany, $period, $onPoint, BookingAddress $addressPoint): self
    {
        $delivery = new static();
        //$delivery->shop_id = $shop_id;
        $delivery->onCity = $onCity;
        $delivery->costCity = $costCity;
        $delivery->minAmountCity = $minAmountCity;
        $delivery->minAmountCompany = $minAmountCompany;
        $delivery->period = $period;
        $delivery->onPoint = $onPoint;
        $delivery->addressPoint = $addressPoint;
        return $delivery;
    }

    public function edit($onCity, $costCity, $minAmountCity, $minAmountCompany, $period, $onPoint, BookingAddress $addressPoint): void
    {
        $this->onCity = $onCity;
        $this->costCity = $costCity;
        $this->minAmountCity = $minAmountCity;
        $this->minAmountCompany = $minAmountCompany;
        $this->period = $period;
        $this->onPoint = $onPoint;
        $this->addressPoint = $addressPoint;
    }

    public function setShop($id)
    {
        if ($this->shop_id == null) $this->shop_id = $id;
    }

    public function addCompany($id)
    {
        $companies = $this->companiesAssign;
        foreach ($companies as $company) {
            if ($company->isFor($id)) throw new \DomainException('Такая ТК уже добавлена');
        }
        $companies[] = DeliveryCompanyAssign::create($id);
        $this->companiesAssign = $companies;
    }

    public function clearCompany()
    {
        $this->companiesAssign = [];
    }

    public static function tableName()
    {
        return '{{%shops_delivery}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'companiesAssign',
                ],
            ],
        ];
    }

    public function afterFind()
    {
        $this->addressPoint = new BookingAddress(
            $this->getAttribute('address'),
            $this->getAttribute('latitude'),
            $this->getAttribute('longitude')
        );
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('address', $this->addressPoint->address);
        $this->setAttribute('latitude', $this->addressPoint->latitude);
        $this->setAttribute('longitude', $this->addressPoint->longitude);

        return parent::beforeSave($insert);
    }

    public function getCompaniesAssign(): ActiveQuery
    {
        return $this->hasMany(DeliveryCompanyAssign::class, ['delivery_id' => 'id']);
    }

    public function getCompanies(): ActiveQuery
    {
        return $this->hasMany(DeliveryCompany::class, ['id' => 'delivery_company_id'])->via('companiesAssign');
    }
}