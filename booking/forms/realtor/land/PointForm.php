<?php


namespace booking\forms\realtor\land;


use booking\entities\realtor\land\Point;
use yii\base\Model;

class PointForm extends Model
{
    public $latitude;
    public $longitude;

    public function __construct(Point $point = null, $config = [])
    {
        if ($point) {
            $this->latitude = $point->latitude;
            $this->longitude = $point->longitude;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['latitude', 'longitude'], 'string'],
        ];
    }
}