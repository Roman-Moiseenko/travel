<?php


namespace booking\forms\foods;


use booking\entities\foods\InfoAddress;
use yii\base\Model;

class InfoAddressForm extends Model
{
    public $phone;
    public $city;
    public $address;
    public $latitude;
    public $longitude;

    public function __construct(InfoAddress $address = null, $config = [])
    {
        if ($address) {
            $this->phone = $address->phone;
            $this->city = $address->city;
            $this->address = $address->address;
            $this->latitude = $address->latitude;
            $this->longitude = $address->longitude;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['phone', 'city', 'address', 'latitude', 'longitude'], 'string'],
        ];
    }
}