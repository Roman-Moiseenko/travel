<?php


namespace booking\forms\booking\funs;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\tours\Tour;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * @property BookingAddressForm $address

 */
class FunCommonForm extends CompositeForm
{
    public $type_id;
    public $name;
    public $description;

    public $name_en;
    public $description_en;

    public $_fun;

    public function __construct(Fun $fun = null, $config = [])
    {
        if ($fun)
        {
            $this->name = $fun->name;
            $this->description = $fun->description;
            $this->name_en = $fun->name_en;
            $this->description_en = $fun->description_en;

            $this->address = new BookingAddressForm($fun->address);
            $this->type_id = $fun->type_id;
            $this->_fun = $fun;
        } else {
            $this->address = new BookingAddressForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description', 'name_en', 'description_en'], 'string'],
            [['name', 'type_id'], 'required', 'message' => 'Обязательное поле'],
            ['type_id', 'integer'],
            ['name', 'unique', 'targetClass' => Fun::class, 'filter' => $this->_fun ? ['<>', 'id', $this->_fun->id] : null, 'message' => 'Такое имя уже есть'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address'];
    }
}