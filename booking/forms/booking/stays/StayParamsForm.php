<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\Stay;
use yii\base\Model;

class StayParamsForm extends Model
{
    public $count_bath; //Кол-во ванных
    public $count_kitchen; //Кол-во кухонь
    public $count_floor; //Колво этажей в доме
    public $square; //Площадь жилья
    public $guest; //кол-во гостей макс
    public $deposit; //Страховой залог
    public $access; //Доступ

    public $isDeposit;

    public function __construct(Stay $stay, $config = [])
    {
        $this->count_bath = $stay->params->count_bath;
        $this->count_kitchen = $stay->params->count_kitchen;
        $this->count_floor = $stay->params->count_floor;
        $this->square = $stay->params->square;
        $this->guest = $stay->params->guest;
        $this->deposit = $stay->params->deposit;
        $this->access = $stay->params->access;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['count_bath', 'count_kitchen', 'count_floor', 'square', 'guest', 'deposit', 'access'], 'integer'],
            ['isDeposit', 'boolean'],
            [['count_bath', 'count_kitchen', 'count_floor', 'square', 'guest'], 'required', 'message' => ''],
        ];
    }
    public function afterValidate()
    {
        parent::afterValidate(); // TODO: Change the autogenerated stub
        if (!$this->isDeposit) $this->deposit = null;
    }
}