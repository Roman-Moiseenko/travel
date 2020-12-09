<?php


namespace booking\forms\booking\funs;


use booking\entities\booking\funs\Characteristic;
use booking\entities\booking\funs\Value;
use yii\base\Model;
/**
 * @property integer $id
 */
class ValueForSearchForm extends Model
{
    public $from;
    public $to;
    public $equal;

    private $_characteristic;

    public function __construct(Characteristic $characteristic, $config = [])
    {
        $this->_characteristic = $characteristic;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return array_filter([
            $this->_characteristic->isString() ? ['equal', 'string', 'enableClientValidation' => false] : false,
            $this->_characteristic->isInteger() || $this->_characteristic->isFloat()? [['from', 'to'], 'integer', 'enableClientValidation' => false] : false
        ]);
    }

    public function isFilled(): bool
    {
        return !empty($this->from) || !empty($this->to) || !empty($this->equal);
    }

    public function variantsList(): array
    {
        return $this->_characteristic->variants ? array_combine($this->_characteristic->variants, $this->_characteristic->variants) : [];
    }

    public function minValue(): string
    {
        return Value::find()->andWhere(['characteristic_id' => $this->_characteristic->id])->min('CAST(value AS SIGNED)');
    }

    public function maxValue(): string
    {
        return Value::find()->andWhere(['characteristic_id' => $this->_characteristic->id])->max('CAST(value AS SIGNED)');
    }


    public function getCharacteristicName(): string
    {
        return $this->_characteristic->name;
    }

    public function getId(): int
    {
        return $this->_characteristic->id;
    }

    public function formName(): string
    {
        return 'v';
    }
}