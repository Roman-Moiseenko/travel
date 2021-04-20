<?php


namespace booking\forms\shops;


use booking\entities\booking\BookingAddress;
use booking\entities\shops\Delivery;
use booking\entities\shops\DeliveryCompany;
use booking\entities\shops\DeliveryCompanyAssign;
use booking\forms\booking\BookingAddressForm;
use booking\forms\CompositeForm;
use booking\helpers\scr;
use booking\helpers\shops\DeliveryHelper;
use yii\base\Model;

/**
 * Class DeliveryForm
 * @package booking\forms\shops
 * @property BookingAddressForm $addressPoint
 */

class DeliveryForm extends CompositeForm
{
    public $onCity; //Есть ли доставка по городу
    public $costCity; //Стоимость доставки
    public $minAmountCity; //Мин.Сумма для доставки по городу
    public $minAmountCompany; //минимальная сумма для доставки ТК
    public $period; //0 - по заказу, 1..7 - сколько раз в неделю
    public $deliveryCompany = []; //транспортные компании
    public $onPoint; //есть ли выдача в городе

  //  public $addressPoint; //адрес откуда можно забрать после оплаты

    public function __construct(Delivery $delivery = null, $config = [])
    {
        //scr::v($delivery);
        if ($delivery) {
            $this->onCity = $delivery->onCity;
            $this->costCity = $delivery->costCity;
            $this->minAmountCity = $delivery->minAmountCity;
            $this->minAmountCompany = $delivery->minAmountCompany;
            $this->period = $delivery->period;
            $this->deliveryCompany = array_map(function (DeliveryCompanyAssign $assign) {return $assign->delivery_company_id; }, $delivery->companiesAssign);
            $this->onPoint = $delivery->onPoint;
            $this->addressPoint = new BookingAddressForm($delivery->addressPoint);
        } else {
            $this->addressPoint = new BookingAddressForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['onCity', 'onPoint'], 'boolean'],
            [['minAmountCity', 'minAmountCompany', 'period', 'costCity'], 'integer'],
            ['deliveryCompany', 'each', 'rule' => ['integer']],
        ];
    }

    protected function internalForms(): array
    {
        return ['addressPoint'];
    }

    public function beforeValidate(): bool
    {
        $this->deliveryCompany = array_filter((array)$this->deliveryCompany);
        return parent::beforeValidate();
    }

}