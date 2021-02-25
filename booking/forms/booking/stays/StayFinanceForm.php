<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\Stay;
use booking\forms\CompositeForm;
use booking\helpers\BookingHelper;
use yii\base\Model;

/**
 * Class ToursFinanceForm
 * @package booking\forms\booking\tours
 */
class StayFinanceForm extends Model
{
    public $legal_id;
    public $cancellation;
    public $check_booking;

    public function __construct(Stay $tour, $config = [])
    {
        $this->legal_id = $tour->legal_id;
        $this->cancellation = $tour->cancellation;

        $this->check_booking = $tour->check_booking;
       // $this->baseCost = new CostForm($tour->baseCost);
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['legal_id', 'integer'],
            ['cancellation', 'integer'],
            ['legal_id', 'required', 'message' => 'Обязательное поле'],
            [['check_booking'], 'in', 'range' => [BookingHelper::BOOKING_CONFIRMATION, BookingHelper::BOOKING_PAYMENT]],
        ];
    }

}