<?php


namespace booking\entities\foods;


use booking\entities\BaseInfoAddress;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class InfoAddress
 * @package booking\entities\booking
 * @property integer $id
 * @property integer $food_id
 * @property string $phone
 * @property string $city
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property Food $food
 */

class InfoAddress extends BaseInfoAddress
{

  /*  public static function create(string $phone, string $city, string $address, string $latitude, string $longitude): self
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
    }*/

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%foods_info_address}}';
    }

    public function getFood(): ActiveQuery
    {
        return $this->hasOne(Food::class, ['id' => 'food_id']);
    }
}