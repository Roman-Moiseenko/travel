<?php


namespace booking\forms\booking\tours;

use yii\base\Model;

class SearchTourForm extends Model
{

    public $date_from;
    public $date_to;
    public $type;
    public $private;
    public $cost_min;
    public $cost_max;

    /*public function __construct($config = [])
    {
        parent::__construct($config);
        if (isset($config['$type'])) $this->type = $config['$type'];
    }*/

    public function rules()
    {
        return [
            [['type', 'private', 'cost_max', 'cost_min'], 'integer', 'enableClientValidation' => false],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
        ];
    }


}