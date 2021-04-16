<?php


namespace booking\forms\shops;


use booking\entities\shops\AdInfoAddress;
use yii\base\Model;

class AdInfoAddressForm extends Model
{
    public $phone;
    public $city;
    public $address;
    public $latitude;
    public $longitude;

    public function __construct(AdInfoAddress $address = null, $config = [])
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