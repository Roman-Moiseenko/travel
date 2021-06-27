<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\trips\placement\Placement;
use booking\forms\booking\BookingAddressForm;
use booking\forms\CompositeForm;

/**
 * Class PlacementForm
 * @package booking\forms\booking\trips
 * @property BookingAddress $address
 * @property AssignComfortForm[] $assignComforts
 */
class PlacementForm extends CompositeForm
{

    public $type_id;
    public $name;
    public $name_en;
    public $description;
    public $description_en;

    public function __construct(Placement $placement = null, $config = [])
    {
        if ($placement) {
            $this->type_id = $placement->type_id;
            $this->name = $placement->name;
            $this->name_en = $placement->name_en;
            $this->description = $placement->description;
            $this->description_en = $placement->description_en;
            $this->address = new BookingAddressForm($placement->address);
            $index = 0;
            $this->assignComforts = array_map(function (Comfort $comfort) use ($placement, &$index) {
                return new AssignComfortForm($comfort, $index++, $placement->getAssignComfort($comfort->id));
            }, Comfort::find()->orderBy('category_id')->all());
        } else {
            $this->address = new BookingAddressForm();
            $index = 0;
            $this->assignComforts = array_map(function (Comfort $comfort) use (&$index) {
                return new AssignComfortForm($comfort, $index++, null);
            }, Comfort::find()->orderBy('category_id')->all());
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['type_id', 'integer'],
            [['name', 'name_en', 'description', 'description_en'], 'string'],
            [['type_id', 'name', 'description'], 'required', 'message' => 'Обязательное поле'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'assignComforts'];
    }
}