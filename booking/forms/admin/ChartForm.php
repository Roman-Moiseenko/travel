<?php


namespace booking\forms\admin;


use yii\base\Model;

class ChartForm extends Model
{
    public $month;
    public $year;
    public $views;
    public $booking;
    public $pay;
    public $confirmation;

    public function __construct($config = [])
    {
        if ($this->month == null) $this->month = 0;
        if (empty($this->year)) $this->year = (int)date('Y', time());
        if ($this->booking == null) $this->booking = true;
        if ($this->pay == null) $this->pay = true;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['month', 'in', 'range' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]],
            ['year', 'integer'],
            [['views', 'booking', 'pay', 'confirmation'], 'boolean'],
        ];
    }
}