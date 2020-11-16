<?php


namespace booking\forms\booking;


use booking\entities\booking\BookingAddress;
use yii\base\Model;

class BookingAddressForm extends Model
{
    public $address;
    public $latitude;
    public $longitude;

    public function __construct(BookingAddress $address = null, $config = [])
    {
        if ($address != null) {
            $this->address = $address->address;
            $this->latitude = $address->latitude;
            $this->longitude = $address->longitude;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['address', 'latitude', 'longitude'], 'string'],
            //[['latitude', 'longitude'], 'required', 'message' => 'Обязательное поле'],
        ];
    }
}