<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\Tour;
use booking\forms\CompositeForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ToursFinanceForm
 * @package booking\forms\booking\tours
 * @property CostForm $baseCost
 */
class TourFinanceForm extends CompositeForm
{
    public $legal_id;
    public $cancellation;
    public $prepay;
    public $extra_time_cost;
    public $extra_time_max;

    public $capacities = [];
    public $transfers = [];

    public function __construct(Tour $tour, $config = [])
    {
        $this->legal_id = $tour->legal_id;
        $this->cancellation = $tour->cancellation;
        $this->prepay = $tour->prepay;
        $this->baseCost = new CostForm($tour->baseCost);
        $this->extra_time_cost = $tour->extra_time_cost;
        $this->extra_time_max = $tour->extra_time_max;
        $this->capacities = ArrayHelper::getColumn($tour->capacities, 'id');
        $this->transfers = ArrayHelper::getColumn($tour->transfers, 'id');
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['legal_id', 'prepay', 'extra_time_cost',  'extra_time_max'], 'integer'],
            ['cancellation', 'integer'],
            ['legal_id', 'required', 'message' => 'Обязательное поле'],
            ['capacities', 'each', 'rule' => ['integer']],
            ['transfers', 'each', 'rule' => ['integer']],
        ];
    }

    protected function internalForms(): array
    {
        return ['baseCost'];
    }

    public function beforeValidate(): bool
    {
        $this->capacities = array_filter((array)$this->capacities);
        $this->transfers = array_filter((array)$this->transfers);
        return parent::beforeValidate();
    }
}