<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\rules\BedsForm;
use booking\forms\booking\stays\rules\CheckInForm;
use booking\forms\booking\stays\rules\LimitForm;
use booking\forms\booking\stays\rules\ParkingForm;
use booking\forms\booking\stays\rules\WifiForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class StayRulesForm
 * @package booking\forms\booking\stays
 * @property BedsForm $beds
 * @property ParkingForm $parking
 * @property CheckInForm $checkin
 * @property LimitForm $limit
 * @property WifiForm $wifi
 */
class StayRulesForm extends CompositeForm
{
    public $stay_id;

    public function __construct(Stay $stay, $config = [])
    {
        $this->stay_id = $stay->id;
        $this->beds = new BedsForm($stay->rules->beds);
        $this->parking = new ParkingForm($stay->rules->parking);
        $this->checkin = new CheckInForm($stay->rules->checkin);
        $this->limit = new LimitForm($stay->rules->limit);
        $this->wifi = new WifiForm($stay->rules->wifi);

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['stay_id', 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['beds', 'parking', 'checkin', 'limit', 'wifi'];
    }
}