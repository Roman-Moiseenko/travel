<?php


namespace booking\forms\booking\tours;


use yii\base\Model;

class SearchToursForm extends Model
{

    public $date_from;
    public $date_to;
    public $type;
    public $private;
    public $cost_min;
    public $cost_max;

    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'string'],
            [['type', 'private', 'cost_max', 'cost_min'], 'integer'],
        ];
    }

}