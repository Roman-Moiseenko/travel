<?php


namespace booking\forms\office\guides;


use booking\entities\booking\Meals;
use yii\base\Model;

class MealTypeForm extends Model
{
    public $mark;
    public $name;


    public function __construct(Meals $type = null, $config = [])
    {
        if ($type != null) {
            $this->name = $type->name;
            $this->mark = $type->mark;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'mark'], 'string'],
            [['name', 'mark'], 'required'],
        ];
    }
}