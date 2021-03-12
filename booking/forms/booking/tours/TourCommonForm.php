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
    public $slug;

    public $name_en;
    public $description_en;

    public $_tour;

    public function __construct(Tour $tours = null, $config = [])
    {
        if ($tours)
        {
            $this->name = $tours->name;
            $this->slug = $tours->slug;
            $this->description = $tours->description;
            $this->name_en = $tours->name_en;
            $this->description_en = $tours->description_en;

            $this->address = new BookingAddressForm($tours->address);
            $this->types = new TourTypeForm($tours);
            $this->_tour = $tours;
        } else {
            $this->address = new BookingAddressForm();
            $this->types = new TourTypeForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description', 'name_en', 'description_en', 'slug'], 'string'],
            ['name', 'required', 'message' => 'Обязательное поле'],
            ['name', 'unique', 'targetClass' => Tour::class, 'filter' => $this->_tour ? ['<>', 'id', $this->_tour->id] : null, 'message' => 'Такое имя уже есть'],

        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'types'];
    }
}