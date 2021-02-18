<?php


namespace booking\forms\office\guides;


use booking\entities\booking\stays\bedroom\TypeOfBed;
use yii\base\Model;

class TypeOfBedForm extends Model
{
    public $name;
    public $count;

    public function __construct(TypeOfBed $typeOfBed = null, $config = [])
    {
        if ($typeOfBed) {
            $this->name = $typeOfBed->name;
            $this->count = $typeOfBed->count;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['count', 'integer'],
            [['name', 'count'], 'required'],
        ];
    }
}