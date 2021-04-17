<?php


namespace booking\entities;


use yii\db\ActiveRecord;

/**
 * Class BaseInfoAddress
 * @package booking\entities
 * @property string $phone
 * @property string $city
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 */
abstract class BaseInfoAddress extends ActiveRecord
{
    const MAX_ADDRESS = 99;

    public static function create(string $phone, string $city, string $address, string $latitude, string $longitude): self
    {
        $info = new static();
        $info->phone = $phone;
        $info->city = $city;
        $info->address = $address;
        $info->latitude = $latitude;
        $info->longitude = $longitude;
        return $info;
    }

    public function edit(string $phone, string $city, string $address, string $latitude, string $longitude): void
    {
        $this->phone = $phone;
        $this->city = $city;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}