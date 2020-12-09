<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\Tour;
use booking\forms\CompositeForm;
use booking\helpers\BookingHelper;
use yii\base\Model;

/**
 * Class ToursFinanceForm
 * @package booking\forms\booking\tours
 * @property CostForm $baseCost
 */
class TourFinanceForm extends CompositeForm
{
    public $legal_id;
    public $cancellation;
    public $pay_bank;
    public $check_booking;

    public function __construct(Tour $tour, $config = [])
    {
        $this->legal_id = $tour->legal_id;
        $this->cancellation = $tour->cancellation;
        $this->pay_bank = $tour->pay_bank;
        $this->check_booking = $tour->check_booking;
        $this->baseCost = new CostForm($tour->baseCost);
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['legal_id', 'integer'],
            ['cancellation', 'integer'],
            ['legal_id', 'required', 'message' => 'Обязательное поле'],
            ['pay_bank', 'boolean'],
            [['check_booking'], 'in', 'range' => [BookingHelper::BOOKING_CONFIRMATION, BookingHelper::BOOKING_PAYMENT]],
        ];
    }

    protected function internalForms(): array
    {
        return ['baseCost'];
    }
}