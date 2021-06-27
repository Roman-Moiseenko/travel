<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\trips\Trip;
use yii\base\Model;

class TripParamsForm extends Model
{
    public $duration;
    public $transfer;
    public $capacity;

    public function __construct(Trip $trip, $config = [])
    {
        $this->duration = $trip->params->duration;
        $this->transfer = $trip->params->transfer;
        $this->capacity = $trip->params->capacity;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['duration', 'capacity', 'transfer'], 'integer'],
            ['duration', 'required', 'message' => 'Обязательное поле'],
        ];
    }
}