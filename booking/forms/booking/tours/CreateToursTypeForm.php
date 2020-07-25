<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\Type;
use yii\base\Model;

class CreateToursTypeForm extends Model
{
    public $name;
    public $mono;

    public function __construct(Type $type = null, $config = [])
    {
        if ($type != null) {
            $this->name = $type->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required'],
        ];
    }
}