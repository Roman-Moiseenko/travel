<?php


namespace booking\forms\booking\rooms;


use booking\entities\booking\rooms\Type;
use yii\base\Model;

class RoomTypeForm extends Model
{
    public $stays_id;
    public $name;

    public function __construct(Type $type = null, $config = [])
    {
        if ($type != null) {
            $this->stays_id = $type->stays_id;
            $this->name = $type->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['stays_id', 'integer'],
            ['name', 'string'],
            [['name', 'stays_id'], 'required'],
        ];
    }
}