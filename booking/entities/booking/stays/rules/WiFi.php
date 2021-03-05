<?php


namespace booking\entities\booking\stays\rules;


use booking\entities\Lang;

class WiFi
{
    const COST_DAY = 2;
    const COST_MB = 3;
    const COST_ALL = 4;
    const AREA_ALL = 10;
    const AREA_COMMON = 20;
    const AREA_HOUSE = 30;

    public $status; //нет, бесплатно, платно
    public $area; //На всей территории / только в местах общего пользования / только в помещениях здания
    public $cost; //цена
    public $cost_type; //сутки, за Мб, за все время

    public function __construct($status = null, $area = null, $cost = null, $cost_type = null)
    {
        $this->status = $status;
        $this->area = $area;
        $this->cost = $cost;
        $this->cost_type = $cost_type;
    }

    public static function listCost(): array
    {
        return [
            self::COST_DAY => Lang::t('1 сутки'),
            self::COST_MB => Lang::t('1 Мб'),
            self::COST_ALL => Lang::t('все время проживания'),
        ];
    }

    public function is(): bool
    {
        return $this->status == Rules::STATUS_FREE || $this->status == Rules::STATUS_PAY;
    }

    public function free(): bool
    {
        return $this->status == Rules::STATUS_FREE;
    }

    public function getStringStatus(): string
    {
        return Rules::listStatus()[$this->status];
    }

    public function getStringCost(): string
    {
        return self::listCost()[$this->cost_type];
    }

    public static function listArea(): array
    {
        return [
            self::AREA_ALL => Lang::t(' на всей территории'),
            self::AREA_COMMON => Lang::t(' только в местах общего пользования'),
            self::AREA_HOUSE => Lang::t(' только в помещениях здания'),
        ];
    }

    public function getStringArea(): string
    {
        return self::listArea()[$this->area];
    }
}