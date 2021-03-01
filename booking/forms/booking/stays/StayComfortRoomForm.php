<?php


namespace booking\forms\booking\stays;

use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\stays\Stay;
use booking\forms\CompositeForm;
use booking\helpers\scr;

/**
 * Class StayComfortForm
 * @package booking\forms\booking\stays
 * @property AssignComfortRoomForm[] $assignComfortsRoom
 */
class StayComfortRoomForm extends CompositeForm
{
    public $stay_id;
    public function __construct(Stay $stay, $config = [])
    {
        $this->stay_id = $stay->id;
        $index = 0;
        $this->assignComfortsRoom = array_map(function (ComfortRoom $comfort) use ($stay, &$index) {
            return new AssignComfortRoomForm($comfort, $index++, $stay->getAssignComfortRoom($comfort->id));
        }, ComfortRoom::find()->orderBy('category_id')->all());
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
        return ['assignComfortsRoom'];
    }
}