<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\ToursParams;
use booking\forms\booking\AgeLimitForm;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\BookingAddressForm2;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class ToursParamsForm
 * @package booking\forms\booking\tours
 * @property BookingAddressForm $beginAddress
 * @property BookingAddressForm2 $endAddress
 * @property AgeLimitForm $ageLimit
 */

class ToursParamsForm extends CompositeForm
{
    public $duration;
    public $private;
    public $groupMin;
    public $groupMax;
  //  public $children;

    public function __construct(ToursParams $params = null, $config = [])
    {
        if ($params != null)
        {
            $this->duration = $params->duration;
            $this->private = $params->private;
            $this->groupMin = $params->groupMin;
            $this->groupMax = $params->groupMax;
            //$this->children = $params->children;
            $this->beginAddress = new BookingAddressForm($params->beginAddress);
            $this->endAddress = new BookingAddressForm2($params->endAddress);
            $this->ageLimit = new AgeLimitForm($params->agelimit);
        } else {
            $this->beginAddress = new BookingAddressForm();
            $this->endAddress = new BookingAddressForm2();
            $this->ageLimit = new AgeLimitForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['duration'], 'string'],
            [['groupMin', 'groupMax'], 'integer', 'min' => 1],
            [['private'], 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return [
            'beginAddress',
            'endAddress',
            'ageLimit'];
    }
}