<?php


namespace booking\entities\shops;


use booking\entities\booking\BookingAddress;

class Delivery
{
    public $onCity; //Есть ли доставка по городу
    public $costCity; //Стоимость доставки
    public $minAmountCity; //Мин.Сумма для доставки по городу
    public $minAmountCompany; //минимальная сумма для доставки ТК
    public $period; //0 - по заказу, 1..7 - сколько раз в неделю
    public $deliveryCompany = []; //транспортные компании
    public $onPoint; //есть ли выдача в городе
    /** @var $addressPoint BookingAddress */
    public $addressPoint; //адрес откуда можно забрать после оплаты ??

    public static function create($onCity, $costCity, $minAmountCity, $minAmountCompany, $period, array $deliveryCompany, $onPoint, BookingAddress $addressPoint): self
    {
        $delivery = new static();
        $delivery->onCity = $onCity;
        $delivery->costCity = $costCity;
        $delivery->minAmountCity = $minAmountCity;
        $delivery->minAmountCompany = $minAmountCompany;
        $delivery->period = $period;
        $delivery->deliveryCompany = $deliveryCompany;
        $delivery->onPoint = $onPoint;
        $delivery->addressPoint = $addressPoint;
        return $delivery;
    }
}