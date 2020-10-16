<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\tours\Tour;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * @property BookingAddressForm $address
 * @property TourTypeForm $types
 */
class TourCommonForm extends CompositeForm
{
    public $name;
    public $description;

    public function __construct(Tour $tours = null, $config = [])
    {
       // $this->photos = new PhotosForm();
        if ($tours)
        {
            $this->name = $tours->name;
            $this->description = $tours->description;
            $this->address = new BookingAddressForm($tours->address);
            $this->types = new TourTypeForm($tours);
        } else {
            $this->address = new BookingAddressForm();
            $this->types = new TourTypeForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            ['name', 'required', 'message' => 'Обязательное поле'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'types'];
    }
}