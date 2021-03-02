<?php


namespace booking\forms\booking\stays\search;


use yii\base\Model;

class _BedroomsForm extends Model
{
    public $name;
    public $checked;
    public $value;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

}