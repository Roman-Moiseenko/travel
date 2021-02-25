<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\rules\BedroomsForm;
use booking\forms\CompositeForm;
use booking\helpers\scr;
use yii\base\Model;

/**
 * Class StayBedroomsForm
 * @package booking\forms\booking\stays
 * @property BedroomsForm[] $bedrooms
 */
class StayBedroomsForm extends CompositeForm
{
    public $stay_id;
    public function __construct(Stay $stay, $config = [])
    {
        $this->stay_id = $stay->id;
        $bedrooms = array_map(function (AssignRoom $room) {
            return new BedroomsForm($room);
        }, $stay->bedrooms);
        $count = count($bedrooms);

        for ($i = 1; $i <= Stay::MAX_BEDROOMS - $count; $i++) {
            $bedrooms[] = new BedroomsForm();
        }
        $this->bedrooms = $bedrooms;
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
        return ['bedrooms'];
    }

    public function afterValidate()
    {
        parent::afterValidate();

        $bedrooms = $this->bedrooms;
        foreach ($bedrooms as $i => $bedroom) {
            $unset = true;
            foreach ($bedroom->bed_count as $count) {
                if ($count != 0) $unset = false;
            }
            if ($unset) unset($bedrooms[$i]);
        }
        $this->bedrooms = $bedrooms;
    }
}