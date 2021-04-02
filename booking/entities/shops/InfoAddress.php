<?php


namespace booking\entities\shops;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class InfoAddress
 * @package booking\entities\shops
 * @property integer $id
 * @property integer $shop_id
 * @property string $phone
 * @property string $city
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property Shop $shop
 */

class InfoAddress extends ActiveRecord
{

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

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%shops_info_address}}';
    }

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }
}