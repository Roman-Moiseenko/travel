<?php


namespace booking\forms\office\guides;


use booking\entities\booking\City;
use booking\entities\message\ThemeDialog;
use yii\base\Model;

class CityForm extends Model
{
    public $name;
    public $name_en;
    public $latitude;
    public $longitude;

    public function __construct(City $city = null, $config = [])
    {
        if ($city != null) {
            $this->name = $city->name;
            $this->name_en = $city->name_en;
            $this->latitude = $city->latitude;
            $this->longitude = $city->longitude;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'name_en', 'latitude', 'longitude'], 'string'],
            [['name'], 'required'],
        ];
    }
}