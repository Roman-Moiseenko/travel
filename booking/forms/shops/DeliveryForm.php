<?php


namespace booking\forms\shops;


use booking\entities\booking\BookingAddress;
use booking\entities\shops\Delivery;
use booking\forms\booking\BookingAddressForm;
use booking\forms\CompositeForm;
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
//    /** @var $addressPoint BookingAddress */
  //  public $addressPoint; //адрес откуда можно забрать после оплаты ??

    public function __construct(Delivery $delivery = null, $config = [])
    {
        if ($delivery) {
            $this->onCity = $delivery->onCity;
            $this->costCity = $delivery->onCity;
            $this->minAmountCity = $delivery->onCity;
            $this->minAmountCompany = $delivery->onCity;
            $this->period = $delivery->onCity;
            $this->deliveryCompany = $delivery->onCity;
            $this->onPoint = $delivery->onCity;
            $this->addressPoint = new BookingAddressForm($delivery->addressPoint);
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['onCity', 'onPoint'], 'boolean'],
            [['minAmountCity', 'minAmountCompany', 'period'], 'integer'],
            ['deliveryCompany', 'each', 'rule' => ['integer']],
        ];
    }

    protected function internalForms(): array
    {
        return ['addressPoint'];
    }
}