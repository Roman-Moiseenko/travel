<?php


namespace booking\forms\booking\funs;

use booking\entities\booking\funs\Characteristic;
use yii\base\Model;

/**
 * @property array variants
 */
class CharacteristicForm extends Model
{

    public $name;
    public $type_variable;
    public $required;
    public $default;
    public $textVariants;
    public $sort;

    private $_characteristic;

    public function __construct($type_fun_id, Characteristic $characteristic = null, $config = [])
    {

        if ($characteristic) {
            $this->name = $characteristic->name;
            $this->type_variable = $characteristic->type_variable;
            $this->required = $characteristic->required;
            $this->default = $characteristic->default;
            $this->textVariants = implode(PHP_EOL, $characteristic->variants);
            $this->sort = $characteristic->sort;
            $this->_characteristic = $characteristic;
        } else {
            $this->sort = Characteristic::find()->andWhere(['type_fun_id' => $type_fun_id])->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'type_variable', 'sort'], 'required'],
            [['required'], 'boolean'],
            [['default'], 'string', 'max' => 255],
            [['textVariants'], 'string'],
            [['sort'], 'integer'],
           // [['name'], 'unique', 'targetClass' => Characteristic::class, 'filter' => $this->_characteristic ? ['<>', 'id', $this->_characteristic->id] : null]
        ];
    }

    public function getVariants(): array
    {
        return preg_split('#[\r\n]+#i', $this->textVariants);
    }


}