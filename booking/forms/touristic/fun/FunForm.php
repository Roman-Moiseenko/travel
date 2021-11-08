<?php


namespace booking\forms\touristic\fun;


use booking\entities\touristic\fun\Fun;
use booking\forms\booking\BookingAddressForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use booking\forms\touristic\TouristicContactForm;

/**
 * Class FunForm
 * @package booking\forms\touristic\fun
 * @property MetaForm $meta
 * @property BookingAddressForm $address
 * @property TouristicContactForm $contact
 */
class FunForm extends CompositeForm
{
    public $category_id;
    public $name;
    public $title;
    public $slug;
    public $description;
    public $content;


    public function __construct(Fun $fun = null, $category_id = null, $config = [])
    {
        if ($fun) {
            $this->category_id = $fun->category_id;
            $this->name = $fun->name;
            $this->title = $fun->title;
            $this->slug = $fun->slug;
            $this->description = $fun->description;
            $this->content = $fun->content;

            $this->contact = new TouristicContactForm($fun->contact);
            $this->meta = new MetaForm($fun->meta);
            $this->address = new BookingAddressForm($fun->address);
        } else {
            if ($category_id) $this->category_id = $category_id;
            $this->contact = new TouristicContactForm();
            $this->meta = new MetaForm();
            $this->address = new BookingAddressForm();
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['name', 'title', 'slug', 'description', 'content'], 'string'],
            [['category_id', 'name'], 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['meta', 'address', 'contact'];
    }
}