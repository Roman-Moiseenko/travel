<?php


namespace booking\forms\booking;


use booking\entities\booking\City;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CitiesForm extends Model
{
    public $cities = [];
    public function __construct($assignmentCity = null, $config = [])
    {
        if ($assignmentCity) {
            $this->cities = ArrayHelper::getColumn($assignmentCity, 'city_id');
        }
        parent::__construct($config);
    }

    public function list(): array
    {
        return ArrayHelper::map(
            City::find()->orderBy('name')->asArray()->all(),
            'id',
            function (array $cities) {
                return $cities['name'];
            }
        );
    }

    public function rules()
    {
        return [
            ['cities', 'each', 'rule' => ['integer']],
        ];
    }

    public function beforeValidate(): bool
    {
        $this->cities = array_filter((array)$this->cities);
        return parent::beforeValidate();
    }
}