<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\bedroom\TypeOfBed;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class AssignRoomForm
 * @package booking\forms\booking\stays
 * @property BedForm[] $beds
 */

//TODO Не используется
class AssignRoomForm extends CompositeForm
{
    public $square;

    public function __construct(AssignRoom $room, $config = [])
    {
        $this->square = $room->square;
        $this->beds = array_map(function (TypeOfBed $typeOfBed) use ($room) {
            return new BedForm($typeOfBed, $room->getCount($typeOfBed->id));
        }, TypeOfBed::find()->orderBy('count')->all());
        parent::__construct($config);
    }

    protected function internalForms(): array
    {
        return ['beds'];
    }

    public function rules()
    {
        return [
            ['square', 'integer', 'min' => 0],
        ];
    }
}