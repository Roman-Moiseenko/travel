<?php


namespace booking\forms\booking;


use booking\entities\booking\Discount;
use yii\base\Model;

class DiscountForm extends Model
{
    public $entities;
    public $entities_id;
    public $percent;
    public $count;
    public $repeat;

    public function __construct(Discount $discount = null, $config = [])
    {
        $this->count = 1;
        $this->repeat = 1;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['entities', 'percent', 'count', 'repeat'], 'required', 'message' => 'Обязательное поле'],
            [['entities_id', 'percent', 'count', 'repeat'], 'integer'],
            [['entities'], 'string'],
        ];
    }
}