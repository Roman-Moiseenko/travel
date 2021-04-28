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
    public $arrayCompanies = []; //транспортные компании
    public $onPoint; //есть ли выдача в городе
    /** @var $addressPoint BookingAddress */
    public $addressPoint; //адрес откуда можно забрать после оплаты ??

    public static function create($onCity, $costCity, $minAmountCity, $minAmountCompany, $period, $company, $onPoint, BookingAddress $addressPoint): self
    {
        $delivery = new static();
        $delivery->onCity = $onCity;
        $delivery->costCity = $costCity;
        $delivery->minAmountCity = $minAmountCity;
        $delivery->minAmountCompany = $minAmountCompany;
        $delivery->period = $period;
        $delivery->arrayCompanies = $company;
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

    public function getCompanies(): array
    {
        if (empty($this->arrayCompanies)) return [];
        return DeliveryCompany::find()->andWhere(['IN', 'id', $this->arrayCompanies])->all();
    }
}