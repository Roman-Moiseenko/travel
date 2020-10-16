<?php


namespace booking\forms\booking\stays;

use booking\entities\booking\stays\Type;
use yii\base\Model;

class StayTypeForm extends Model
{
    public $name;
    public $mono;

    public function __construct(Type $type = null, $config = [])
    {
        if ($type != null) {
            $this->name = $type->name;
            $this->mono = $type->mono;
        } else {
            $this->mono = false;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required', 'message' => 'Обязательное поле'],
            ['mono', 'boolean'],
        ];
    }
}