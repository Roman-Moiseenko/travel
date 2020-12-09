<?php


namespace booking\forms\booking\funs;

use booking\entities\booking\funs\Fun;
use yii\base\Model;

class FunTypeForm extends Model
{
    public $type;
    public $others = [];

    public function __construct(Fun $fun = null, $config = [])
    {
        if ($fun) {
            $this->type = $fun->type_id;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['type', 'required', 'message' => 'Обязательное поле'],
            ['type', 'integer'],
        ];
    }

    public function beforeValidate(): bool
    {
        $this->others = array_filter((array)$this->others);
        return parent::beforeValidate();
    }
}