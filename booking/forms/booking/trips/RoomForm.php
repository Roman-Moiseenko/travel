<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\trips\placement\room\Room;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;

/**
 * Class RoomForm
 * @package booking\forms\booking\trips
 * @property PhotosForm $photos
 * @property AssignComfortRoomForm $assignComforts
 */
class RoomForm extends CompositeForm
{
public $name;
public $name_en;

public $quantity;
public $meals_id;

public $cost; // стоимость за номер  если $shared == false и за 1 человека если $shared == true
public $capacity; // Максимальная вместимость
public $shared;
    public function __construct(Room $room = null, $config = [])
    {
        if ($room) {
            $this->name = $room->name;
            $this->name_en = $room->name_en;
            $this->quantity = $room->quantity;
            $this->meals_id = $room->meals_id;
            $this->cost = $room->cost;
            $this->capacity = $room->capacity;
            $this->shared = $room->shared;

            $index = 0;
            $this->assignComforts = array_map(function (ComfortRoom $comfort) use ($room, &$index) {
                return new AssignComfortRoomForm($comfort, $index++, $room->getAssignComfort($comfort->id));
            }, ComfortRoom::find()->orderBy('category_id')->all());
        } else {
            $index = 0;
            $this->assignComforts = array_map(function (ComfortRoom $comfort) use (&$index) {
                return new AssignComfortRoomForm($comfort, $index++);
            }, ComfortRoom::find()->orderBy('category_id')->all());
        }

        $this->photos = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'name_en'], 'string'],
            [['quantity', 'meals_id', 'cost', 'capacity'], 'integer'],
            [['shared'], 'boolean'],
            [['name', 'quantity', 'cost', 'capacity'], 'required', 'message' => 'Обязательное поле'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photos', 'assignComforts'];
    }
}