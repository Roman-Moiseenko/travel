<?php


namespace booking\forms\booking\trips;

use yii\base\Model;

class SearchTripForm extends Model
{

    public $date_from;
    public $date_to;
    public $type_id;
    public $cost_min;
    public $cost_max;

    public function __construct($type_id = null, $config = [])
    {
        if ($type_id) $this->type_id = $type_id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type_id', 'cost_max', 'cost_min'], 'integer', 'enableClientValidation' => false],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
        ];
    }

}