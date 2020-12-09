<?php


namespace booking\forms\booking\funs;


use booking\entities\booking\funs\Characteristic;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\Value;
use booking\forms\CompositeForm;
use yii\base\Model;
/**
 * @property ValueForSearchForm[] $values
 */
class SearchFunForm extends CompositeForm
{

    public $date_from;
    public $date_to;
    public $type;

    public function __construct($config = [])
    {
        $this->values = [];
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type'], 'integer', 'enableClientValidation' => false],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
        ];
    }

    public function setAttribute($type_id)
    {
        $funs = Fun::find()->select('id')->andWhere(['type_id' => $type_id])->asArray()->column();
        $char_id = Value::find()->select('characteristic_id')->andWhere(['fun_id' => $funs])->asArray()->column();
        $this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForSearchForm($characteristic);
        }, Characteristic::find()->andWhere(['id' => $char_id])->orderBy('sort')->all());
    }

    protected function internalForms(): array
    {
        return ['values'];
    }
}