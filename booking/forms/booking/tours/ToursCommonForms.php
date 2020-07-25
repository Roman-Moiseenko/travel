<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\tours\Tours;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * @property BookingAddressForm $address
 * @property PhotosForm $photos
 * @property ToursTypeForm $types
 */
class ToursCommonForms extends CompositeForm
{
    public $name;
    public $description;

    public function __construct(Tours $tours, $config = [])
    {
        $this->photos = new PhotosForm();
        if ($tours)
        {
            $this->name = $tours->name;
            $this->description = $tours->description;
            $this->address = new BookingAddressForm($tours->address);
            $this->types = new ToursTypeForm($tours);
        } else {
            $this->address = new BookingAddressForm();
            $this->types = new ToursTypeForm();
        }
        parent::__construct($config);
    }

    protected function internalForms(): array
    {
        return ['address', 'photos', 'types'];
    }
}