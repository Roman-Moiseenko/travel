<?php


namespace booking\forms\blog\map;


use booking\entities\blog\map\Point;
use booking\entities\booking\BookingAddress;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;

/**
 * Class PointForm
 * @package booking\forms\blog\map
 * @property BookingAddressForm $geo
 * @property PhotosForm $photo
 */

class PointForm extends CompositeForm
{
    public $caption;
    public $link;

    public function __construct(Point $point = null,$config = [])
    {
        if ($point) {
            $this->caption = $point->caption;
            $this->link = $point->link;
            $this->photo = $point->photo;
            $this->geo = new BookingAddressForm($point->geo);

        } else {
            $this->geo = new BookingAddressForm();
        }
        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['caption', 'link'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['geo', 'photo'];
    }
}