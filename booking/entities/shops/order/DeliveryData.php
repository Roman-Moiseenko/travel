<?php


namespace booking\entities\shops\order;


class DeliveryData
{
    const METHOD_POINT = 1;
    const METHOD_CITY = 2;
    const METHOD_COMPANY = 3;

    public $method; //Способ доставки
    public $address_index;
    public $address_city;
    public $address_street;
    public $on_hands;
    public $fullname;
    public $phone;


    public static function create($method, $address_index, $address_city, $address_street, $on_hands, $fullname, $phone): self
    {
        $delivery = new static();
        $delivery->method = $method;
        $delivery->address_index = $address_index;
        $delivery->address_city = $address_city;
        $delivery->address_street = $address_street;
        $delivery->on_hands = $on_hands;
        $delivery->fullname = $fullname;
        $delivery->phone = $phone;
        return $delivery;
    }
}