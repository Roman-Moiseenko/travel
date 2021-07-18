<?php


namespace booking\forms\moving;


use booking\entities\moving\Item;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;

/**
 * Class ItemForm
 * @package booking\forms\moving
 * @property BookingAddressForm $address
 * @property PhotosForm $photos
 */
class ItemForm extends CompositeForm
{
    public $title;
    public $text;

    public function __construct(Item $item = null, $config = [])
    {
        if ($item) {
            $this->title = $item->title;
            $this->text = $item->text;
            $this->address = new BookingAddressForm($item->address);
        } else {
            $this->address = new BookingAddressForm();
        }

        $this->photos = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['text', 'title'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'photos'];
    }
}