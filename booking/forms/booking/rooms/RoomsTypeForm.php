<?php


namespace booking\forms\booking\rooms;


use booking\entities\booking\rooms\RoomsType;
use yii\base\Model;

class RoomsTypeForm extends Model
{
    public $stays_id;
    public $name;

    public function __construct(RoomsType $roomsType = null, $config = [])
    {
        if ($roomsType != null) {
            $this->stays_id = $roomsType->stays_id;
            $this->name = $roomsType->name;
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