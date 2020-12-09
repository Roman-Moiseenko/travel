<?php


namespace booking\forms\booking\funs;


use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\Times;
use booking\forms\booking\tours\CostForm;
use booking\forms\CompositeForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\base\Model;

/**
 * Class ToursFinanceForm
 * @package booking\forms\booking\tours
 * @property CostForm $baseCost
 * @property TimesForm[] $times
 */
class FunFinanceForm extends CompositeForm
{
    public $legal_id;
    public $cancellation;
    public $pay_bank;
    public $check_booking;
    public $type_time;
    public $quantity;

    public function __construct(Fun $fun, $config = [])
    {
        $this->type_time = $fun->type_time;
        $this->legal_id = $fun->legal_id;
        $this->quantity = $fun->quantity ?? 1;
        $this->cancellation = $fun->cancellation;
        $this->pay_bank = $fun->pay_bank;
        $this->check_booking = $fun->check_booking;
        $this->baseCost = new CostForm($fun->baseCost);

        /*$_times = array_map(function (Times $times) {
            return new TimesForm($times);
        }, $fun->times);*/
        //Добавляем до 50
        $n = 50;// - count($_times);
        for ($i = 0; $i < $n; $i++) {
            $_times[] = new TimesForm();
        }
        $this->times = $_times;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['legal_id', 'type_time', 'cancellation', 'quantity'], 'integer'],
            [['legal_id', 'type_time', 'quantity'], 'required', 'message' => 'Обязательное поле'],
            ['pay_bank', 'boolean'],
            [['check_booking'], 'in', 'range' => [BookingHelper::BOOKING_CONFIRMATION, BookingHelper::BOOKING_PAYMENT]],
        ];
    }

    protected function internalForms(): array
    {
        return ['baseCost', 'times'];
    }

    public function load($data, $formName = null)
    {
        //Если типы не предполагают время, то очищаем массив times
        if (isset($data['FunFinanceForm']))
            if (Fun::isClearTimes($data['FunFinanceForm']['type_time'])) $this->times = [];
        return parent::load($data, $formName);
    }

}