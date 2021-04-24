<?php


namespace booking\forms\shops;


use booking\entities\shops\order\Order;
use yii\base\Model;


class OrderForm extends Model
{
    public $comment;
    public $method;
    public $address_index;
    public $address_city;
    public $address_street;
    public $on_hands;
    public $fullname;
    public $phone;
    public $company;

    public function __construct(Order $order = null, $config = [])
    {
        if ($order) {
            $this->comment = $order->comment;
            $this->address_index = $order->deliveryData->address_index;
            $this->address_city = $order->deliveryData->address_city;
            $this->address_street = $order->deliveryData->address_street;
            $this->on_hands = $order->deliveryData->on_hands;
            $this->fullname = $order->deliveryData->fullname;
            $this->phone = $order->deliveryData->phone;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['method', 'company'], 'integer'],
            [['comment', 'address_index', 'address_city', 'address_street', 'fullname', 'phone'], 'string'],
            ['on_hands', 'boolean'],
            ['method', 'required', 'message' => 'Обязательное поле'],
        ];
    }
}