<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\trips\Trip;
use yii\base\Model;


/**
 * Class TripFinanceForm
 * @package booking\forms\booking\trips
 */
class TripFinanceForm extends Model
{
    public $legal_id;
    public $cancellation;
    public $prepay;
    public $cost_base;


    public function __construct(Trip $trip, $config = [])
    {
        $this->legal_id = $trip->legal_id;
        $this->cancellation = $trip->cancellation;
        $this->prepay = $trip->prepay;
        $this->cost_base = $trip->cost_base;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['legal_id', 'prepay', 'cost_base'], 'integer'],
            ['cancellation', 'integer'],
            ['legal_id', 'required', 'message' => 'Обязательное поле'],

        ];
    }

}