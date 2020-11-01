<?php


namespace booking\forms\admin;


use yii\base\Model;

class ChartForm extends Model
{
    public $month;
    public $year;

    public function __construct($config = [])
    {
        if ($this->month == null) $this->month = 0;
        if ($this->year == null) $this->year = (int)date('Y', time());

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['month', 'in', 'range' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]],
            ['year', 'integer'],
        ];
    }
}