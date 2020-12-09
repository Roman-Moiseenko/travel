<?php


namespace booking\forms\booking\funs;


use booking\entities\booking\funs\BookingFun;
use booking\forms\booking\tours\CostForm;
use booking\forms\CompositeForm;

/**
 * @property CostForm $count
 */
class BookingFunForm extends CompositeForm
{
    public $calendar_id;

    public function __construct(BookingFun $booking = null, $config = [])
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