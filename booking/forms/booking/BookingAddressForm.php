<?php


namespace booking\forms\booking;


use booking\entities\booking\BookingAddress;
use yii\base\Model;

class BookingAddressForm extends Model
{
    public $town;
    public $street;
    public $house;

    public $latitude;
    public $longitude;

    public function __construct(BookingAddress $address = null, $config = [])
    {
        if ($address != null) {
            $this->town = $address->town;
            $this->street = $address->street;
            $this->house = $address->house;
            $this->latitude = $address->latitude;
            $this->longitude = $address->longitude;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['town', 'street', 'house'], 'string'],
            [['latitude', 'longitude'], 'required'],
            [['latitude', 'longitude'], 'integer']
        ];
    }
}