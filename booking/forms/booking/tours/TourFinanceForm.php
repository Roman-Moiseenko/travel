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
    public $check_booking;
    public $prepay;

    public function __construct(Tour $tour, $config = [])
    {
        $this->legal_id = $tour->legal_id;
        $this->cancellation = $tour->cancellation;
        $this->prepay = $tour->prepay;
        $this->check_booking = $tour->check_booking;
        $this->baseCost = new CostForm($tour->baseCost);
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['legal_id', 'prepay'], 'integer'],
            ['cancellation', 'integer'],
            ['legal_id', 'required', 'message' => 'Обязательное поле'],
            [['check_booking'], 'in', 'range' => [BookingHelper::BOOKING_CONFIRMATION, BookingHelper::BOOKING_PAYMENT]],
        ];
    }

    protected function internalForms(): array
    {
        return ['baseCost'];
    }
}