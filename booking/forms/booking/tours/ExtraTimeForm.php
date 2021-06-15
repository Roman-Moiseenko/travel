<?php


namespace booking\forms\booking\tours;


use yii\base\Model;

class ExtraTimeForm extends Model
{
    public $extra_time_cost;
    public $extra_time_max;

    public function rules()
    {
        return [
            [['extra_time_cost', 'extra_time_max'], 'integer'],
        ];
    }
}