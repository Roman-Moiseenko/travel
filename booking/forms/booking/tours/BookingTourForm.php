<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\BookingTour;
use booking\forms\CompositeForm;

/**
 * Class BookingToursForm
 * @package booking\forms\booking\tours
 * @property CostForm $count
 */
class BookingTourForm extends CompositeForm
{
    public $calendar_id;

    public function __construct(BookingTour $booking = null, $config = [])
    {
        if (!$booking) {
            $this->calendar_id = $booking->calendar_id;
            $this->count = new CostForm($booking->count);
        } else {
            $this->count = new CostForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['calendar_id', 'integer'],
            ['calendar_id', 'required', 'message' => 'Обязательное поле'],
        ];
    }

    protected function internalForms(): array
    {
        return ['count'];
    }
}