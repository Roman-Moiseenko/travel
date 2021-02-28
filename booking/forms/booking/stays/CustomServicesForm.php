<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\CustomServices;
use yii\base\Model;

class CustomServicesForm extends Model
{
    public $name;
    public $value;
    public $payment;

    public function __construct(CustomServices $service = null, $config = [])
    {
        if ($service) {
            $this->name = $service->name;
            $this->value = $service->value;
            $this->payment = $service->payment;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            [['value', 'payment'], 'integer'],
        ];
    }
}