<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\nearby\Nearby;
use yii\base\Model;

class NearbyForm extends Model
{
    public $name;
    public $category_id;
    public $distance;
    public $unit;

    public function __construct(Nearby $nearby = null, $config = [])
    {
        if ($nearby) {
            $this->name = $nearby->name;
            $this->category_id = $nearby->category_id;
            $this->distance = $nearby->distance;
            $this->unit = $nearby->unit;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['name', 'unit'], 'string'],
            [['distance', 'category_id'], 'integer'],
        ];
    }
}