<?php


namespace booking\forms;


use booking\entities\BaseInfoAddress;
use yii\base\Model;

class InfoAddressForm extends Model
{
    public $phone;
    public $city;
    public $address;
    public $latitude;
    public $longitude;

    public function __construct(BaseInfoAddress $address = null, $config = [])
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