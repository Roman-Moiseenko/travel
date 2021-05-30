<?php


namespace booking\forms\office;


use booking\entities\office\PriceList;
use yii\base\Model;

class PriceListForm extends Model
{
    public $key;
    public $amount;
    public $period;
    public $name;

    public function __construct(PriceList $priceList = null, $config = [])
    {
        if ($priceList) {
            $this->key = $priceList->key;
            $this->amount = $priceList->amount;
            $this->period = $priceList->period;
            $this->name = $priceList->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['key', 'string'],
            ['amount', 'number'],
            ['period', 'integer'],
            [['key', 'amount', 'period'], 'required', 'message' => 'Обязательное поле'],
        ];
    }

}