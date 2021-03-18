<?php


namespace booking\forms\booking\cars;


use booking\entities\booking\cars\Car;
use booking\helpers\BookingHelper;
use yii\base\Model;

/**
 * Class CarFinanceForm
 * @package booking\forms\booking\tours
 */
class CarFinanceForm extends Model
{
    public $legal_id;
    public $cancellation;
    public $check_booking;
    public $deposit;
    public $cost;
    public $quantity;
    public $discount_of_days;
    public $prepay;

    public function __construct(Car $car, $config = [])
    {
        $this->legal_id = $car->legal_id;
        $this->prepay = $car->prepay;
        $this->cancellation = $car->cancellation;
        $this->check_booking = $car->check_booking;
        $this->deposit = $car->deposit;
        $this->cost = $car->cost;
        $this->quantity = $car->quantity;
        $this->discount_of_days = $car->discount_of_days;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['legal_id', 'prepay', 'cancellation', 'deposit','cost', 'quantity', 'discount_of_days'], 'integer'],
            [['legal_id','cost','quantity'], 'required', 'message' => 'Обязательное поле'],
            [['check_booking'], 'in', 'range' => [BookingHelper::BOOKING_CONFIRMATION, BookingHelper::BOOKING_PAYMENT]],
          //  ['check_booking', 'required', 'message' => 'Обязательное поле']
        ];
    }

}