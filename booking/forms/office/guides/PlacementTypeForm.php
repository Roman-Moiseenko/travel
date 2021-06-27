<?php


namespace booking\forms\office\guides;


use booking\entities\booking\trips\placement\Type;
use yii\base\Model;

class PlacementTypeForm extends Model
{
    public $name;

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
            [['name'], 'string'],
            ['name', 'required'],
        ];
    }
}