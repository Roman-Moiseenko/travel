<?php


namespace booking\forms\realtor;


use booking\entities\realtor\Landowner;
use booking\forms\booking\BookingAddressForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;

/**
 * Class LandownerForm
 * @package booking\forms\realtor
 * @property BookingAddressForm $address
 * @property MetaForm $meta
 */
class LandownerForm extends CompositeForm
{
    public $name;
    public $slug;
    public $caption;
    public $phone;
    public $email;

    public $cost;
    public $description;
    public $distance;
    public $count;
    public $size;

    public $text;

    public function __construct(Landowner $landowner = null, $config = [])
    {
        if ($landowner) {
            $this->name = $landowner->name;
            $this->slug = $landowner->slug;
            $this->caption = $landowner->caption;
            $this->phone = $landowner->phone;
            $this->email = $landowner->email;
            $this->cost = $landowner->cost;
            $this->description = $landowner->description;
            $this->distance = $landowner->distance;
            $this->count = $landowner->count;
            $this->size = $landowner->size;
            $this->text = $landowner->text;

            $this->address = new BookingAddressForm($landowner->address);
            $this->meta = new MetaForm($landowner->meta);
        } else {
            $this->address = new BookingAddressForm();
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['name', 'slug', 'caption', 'phone', 'email', 'description', 'text'], 'string'],
            [['cost', 'size', 'count'], 'integer'],
            [['distance'], 'number'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'meta'];
    }
}