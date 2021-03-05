<?php


namespace booking\entities\booking\stays\rules;


use booking\entities\Lang;

class Parking
{
    const COST_HOUR = 1;
    const COST_DAY = 2;
    const COST_MONTH = 3;
    const COST_ALL = 4;

    public $status; //нет, бесплатно, платно
    public $private; //частная / общественная
    public $inside; //на территории или за пределами
    public $reserve; ////возможность забронировать
    public $cost; //цена
    public $cost_type; //час, сутки, месяц, за все время
    public $security; //охраняемая
    public $covered;//крытая
    public $street;//уличная
    public $invalid; //Парковочные места для людей с ограниченными физическими возможностями

    public function __construct($status = null, $private = null, $inside = null, $reserve = null, $cost = null,
                                $cost_type = null, $security = null, $covered = null, $street = null, $invalid = null)
    {
        $this->status = $status;
        $this->private = $private;
        $this->inside = $inside;
        $this->reserve = $reserve;
        $this->cost = $cost;

        $this->cost_type = $cost_type;
        $this->security = $security;
        $this->covered = $covered;
        $this->street = $street;
        $this->invalid = $invalid;

    }

    public static function listCost(): array
    {
        return [
            self::COST_HOUR => Lang::t('1 час'),
            self::COST_DAY => Lang::t('1 сутки'),
            self::COST_MONTH => Lang::t('1 месяц'),
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

    public static function listPrivate(): array
    {
        return [true => 'частная', false => 'общественная'];
    }

    public static function listInside(): array
    {
        return [true => 'на территории', false => 'за пределами территории'];
    }
}