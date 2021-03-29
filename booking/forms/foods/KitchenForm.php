<?php


namespace booking\forms\foods;


use booking\entities\foods\Kitchen;
use yii\base\Model;

class KitchenForm extends Model
{
    public $name;

    public function __construct(Kitchen $kitchen = null, $config = [])
    {
        if ($kitchen) {
            $this->name = $kitchen->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required'],
        ];
    }
}