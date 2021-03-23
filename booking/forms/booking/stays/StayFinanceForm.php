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
    public $cost_base;
    public $guest_base;
    public $cost_add;
    public $prepay;
    public $min_rent;

    public function __construct(Stay $stay, $config = [])
    {
        $this->legal_id = $stay->legal_id;
        $this->prepay = $stay->prepay;

        $this->cancellation = $stay->cancellation;
        $this->cost_base = $stay->cost_base;
        $this->guest_base = $stay->guest_base;
        $this->cost_add = $stay->cost_add;
        $this->min_rent = $stay->min_rent;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['legal_id', 'cost_base', 'guest_base', 'cost_add', 'prepay', 'min_rent'], 'integer'],
            ['cancellation', 'integer'],
            [['legal_id', 'cost_base', 'guest_base'], 'required', 'message' => 'Обязательное поле'],
        ];
    }

}