<?php


namespace booking\entities\booking\stays;


class StayParams
{
    //public $stars;
    //const
//TODO Варианты доступа $access
    public $count_bath; //Кол-во ванных
    public $count_kitchen; //Кол-во кухонь
    public $count_floor; //Колво этажей в доме
    public $square; //Площадь жилья
    public $guest; //кол-во гостей макс
    public $deposit; //Страховой залог
    public $access; //Доступ

    public function __construct($square = null, $count_bath = null, $count_kitchen = null, $count_floor = null, $guest = null, $deposit = null, $access = null)
    {
        $this->square = $square;
        $this->count_bath = $count_bath;
        $this->count_kitchen = $count_kitchen;
        $this->count_floor = $count_floor;
        $this->guest = $guest;
        $this->deposit = $deposit;
        $this->access = $access;
    }

    public static function listAccess(): array
    {
        return [
            1 => 'Ключи будут на стойке регистрации',
            2 => 'Гостя встретят',
            3 => 'На двери кодовый замок',
            4 => 'Мы отправим инструкцию',
            5 => 'Ключи спрятанны в секретном месте'
        ];
    }
}