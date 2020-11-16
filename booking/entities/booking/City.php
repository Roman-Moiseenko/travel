<?php


namespace booking\entities\booking;


use booking\entities\Lang;
use yii\db\ActiveRecord;

/**
 * Class City
 * @package booking\entities\booking
 * @property integer $id
 * @property string $name
 * @property string $name_en
 * @property string $latitude
 * @property string $longitude
 * @property Car[] $assignCar
 */

class City extends ActiveRecord
{
    public static function create($name, $name_en, $latitude, $longitude): self
    {
        $city = new static();
        $city->name = $name;
        $city->name_en = $name_en;
        $city->latitude = $latitude;
        $city->longitude = $longitude;
        return $city;
    }

    public function edit($name, $name_en, $latitude, $longitude): void
    {
        $this->name = $name;
        $this->name_en = $name_en;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public static function tableName()
    {
        return '{{%booking_service_city}}';
    }
}