<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\Tour;
use booking\forms\CompositeForm;
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

    public function __construct(Tour $tour, $config = [])
    {
        $this->legal_id = $tour->legal_id;
        $this->cancellation = $tour->cancellation;
        $this->baseCost = new CostForm($tour->baseCost);
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['legal_id', 'integer'],
            ['cancellation', 'integer'],
            ['legal_id', 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['baseCost'];
    }
}