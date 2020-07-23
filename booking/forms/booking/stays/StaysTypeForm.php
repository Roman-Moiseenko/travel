<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\StaysType;
use yii\base\Model;

class StaysTypeForm extends Model
{
    public $name;
    public $mono;

    public function __construct(StaysType $staysType = null, $config = [])
    {
        if ($staysType != null) {
            $this->name = $staysType->name;
            $this->mono = $staysType->mono;
        } else {
            $this->mono = false;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required'],
            ['mono', 'boolean'],
        ];
    }
}