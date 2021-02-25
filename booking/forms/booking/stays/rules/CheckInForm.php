<?php


namespace booking\forms\booking\stays\rules;


use booking\entities\booking\stays\rules\CheckIn;
use yii\base\Model;

class CheckInForm extends Model
{
    public $message;
    public $checkin_from;
    public $checkin_to;
    public $checkout_from;
    public $checkout_to;

    public function __construct(CheckIn $checkIn, $config = [])
    {
        $this->message = $checkIn->message;
        $this->checkin_from = $checkIn->checkin_from;
        $this->checkin_to = $checkIn->checkin_to;
        $this->checkout_from = $checkIn->checkout_from;
        $this->checkout_to = $checkIn->checkout_to;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['message'], 'boolean'],
            [['checkin_from', 'checkin_to', 'checkout_from', 'checkout_to'], 'integer'],
        ];
    }
}