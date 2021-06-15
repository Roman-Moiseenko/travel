<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\services\Capacity;
use yii\base\Model;

class CapacityForm extends Model
{
    public $count;
    public $percent;

    public function __construct(Capacity $capacity = null, $config = [])
    {
        if ($capacity) {
            $this->count = $capacity->count;
            $this->percent = $capacity->percent;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['count', 'percent'], 'integer'],
            [['count', 'percent'], 'required', 'message' => 'Обязательное поле'],

        ];
    }
}