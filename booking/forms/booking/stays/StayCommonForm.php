<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\Stay;
use booking\forms\booking\BookingAddressForm;
use booking\forms\CompositeForm;

/**
 * @property BookingAddressForm $address
 */

class StayCommonForm extends CompositeForm
{
    public $name;
    public $description;
    public $name_en;
    public $description_en;
    public $type_id;

    public $_stay;

    public function __construct(Stay $stay = null, $config = [])
    {
        if ($stay)
        {
            $this->name = $stay->name;
            $this->description = $stay->description;
            $this->name_en = $stay->name_en;
            $this->description_en = $stay->description_en;

            $this->address = new BookingAddressForm($stay->address);
            $this->type_id = $stay->type;
            $this->_stay = $stay;
        } else {
            $this->address = new BookingAddressForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description', 'name_en', 'description_en'], 'string'],
            [['name', 'description', 'type_id'], 'required', 'message' => 'Обязательное поле'],
            ['type_id', 'integer'],
            ['name', 'unique', 'targetClass' => Stay::class, 'filter' => $this->_stay ? ['<>', 'id', $this->_stay->id] : null, 'message' => 'Такое имя уже есть'],
        ];
    }

    protected function internalForms(): array
    {
        return [
            'address',
        ];
    }
}