<?php


namespace booking\entities\booking;


class Payment
{
//* @property float $pay_merchant - % оплаты клиентом комиссии: 0 - оплачивает провайдер ..... исключить

    public $percent; //процент предоплаты 0, 20, 50, 100
    public $full_cost; // - полная стоимость бронирования
    public $prepay; // - оплаченая часть бронирования, ч/з ЮКассу
    public $provider;// - выплата провайдеру

    public $id;// - ID платежа по ЮКассе
    public $date;// - дата оплаты
    public $merchant;// - оплата комиссии банку (в руб)
    public $deduction;// - оплата вознаграждения порталу (в руб)
    public $confirmation;// - код подтверждения, для неоплачиваемых

    public function __construct($full_cost = 0, $id = null, $date = null, $prepay = 0, $percent = 0, $provider = 0, $merchant = 0, $deduction = 0, $confirmation = null)
    {
        $this->percent = $percent;
        $this->full_cost = $full_cost;
        $this->prepay = $prepay;
        $this->provider = $provider;
        $this->id = $id;
        $this->date = $date;
        $this->merchant = $merchant;
        $this->deduction = $deduction;
        $this->confirmation = $confirmation;
    }

    public function confirmation(): bool
    {
        return $this->percent == 0;
    }

    public function getPrepay()
    {
        return $this->prepay;
    }

    public function getFull()
    {
        return $this->full_cost;
    }

    public function getProvider()
    {
        return $this->provider;
    }

}