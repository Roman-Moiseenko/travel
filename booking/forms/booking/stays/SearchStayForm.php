<?php


namespace booking\forms\booking\stays;


use yii\base\Model;

class SearchStayForm extends Model
{
    public $date_from;
    public $date_to;
    public $type;
    public $city;
    public $guest;
    public $children;
    public $values;

    public function __construct($config = [])
    {
        $this->values = [];
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type', 'city', 'guest', 'children'], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
        ];
    }
}