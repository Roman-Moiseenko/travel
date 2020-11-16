<?php


namespace booking\forms\booking\cars;


use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\Characteristic;
use booking\entities\booking\cars\Type;
use booking\entities\booking\cars\Value;
use booking\forms\CompositeForm;
use yii\base\Model;
/**
 * @property ValueForSearchForm[] $values
 */
class SearchCarForm extends CompositeForm
{

    public $date_from;
    public $date_to;
    public $type;
    public $city;

    public function __construct($config = [])
    {
        $this->values = [];
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type', 'city'], 'integer', 'enableClientValidation' => false],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
        ];
    }

    public function setAttribute($type_id)
    {
        $cars = Car::find()->select('id')->andWhere(['type_id' => $type_id])->asArray()->column();
        $char_id = Value::find()->select('characteristic_id')->andWhere(['car_id' => $cars])->asArray()->column();
        $this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForSearchForm($characteristic);
        }, Characteristic::find()->andWhere(['id' => $char_id])->orderBy('sort')->all());
    }

    protected function internalForms(): array
    {
        return ['values'];
    }
}