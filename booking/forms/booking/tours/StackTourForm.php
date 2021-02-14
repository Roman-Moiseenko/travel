<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\stack\Stack;
use yii\base\Model;

class StackTourForm extends Model
{
    public $legal_id;
    public $count;
    public $name;
    //public

    public function __construct(Stack $stack = null, $config = [])
    {
        if ($stack) {
            $this->legal_id = $stack->legal_id;
            $this->count = $stack->count;
            $this->name = $stack->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['legal_id', 'count'], 'integer'],
            ['name', 'string'],
            [['legal_id', 'count', 'name'], 'required', 'message' => 'Обязательное поле'],
        ];
    }
}