<?php


namespace booking\forms\booking\cars;


use booking\entities\booking\BookingAddress;

use booking\entities\booking\cars\Car;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\CitiesForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * @property BookingAddressForm $address
 * @property CitiesForm $cities
 */
class CarCommonForm extends CompositeForm

{
    public $name;
    public $description;
    public $type_id;
    public $name_en;
    public $description_en;
    public $year;


    public $_car;

    public function __construct(Car $car = null, $config = [])
    {
       // $this->photos = new PhotosForm();
        if ($car)
        {
            $this->name = $car->name;
            $this->year = $car->year;
            $this->description = $car->description;
            $this->name_en = $car->name_en;
            $this->type_id = $car->type_id;
            $this->description_en = $car->description_en;
            $this->_car = $car;
            $this->cities = new CitiesForm($car->assignmentCities);
        } else {
            $this->cities = new CitiesForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description', 'name_en', 'description_en'], 'string'],
            [['name', 'type_id', 'description'], 'required', 'message' => 'Обязательное поле'],
            ['type_id', 'integer'],
            [['year'], 'integer', 'min' => '1970', 'max' => (int)date('Y', time())],
        ];
    }

    protected function internalForms(): array
    {
        return ['cities'];
    }
}