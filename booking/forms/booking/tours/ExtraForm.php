<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\Extra;
use yii\base\Model;

class ExtraForm extends Model
{
    public $name;
    public $description;
    public $cost;

    public function __construct(Extra $extra = null, $config = [])
    {
        if ($extra) {
            $this->name = $extra->name;
            $this->description = $extra->description;
            $this->cost = $extra->cost;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            ['name', 'required'],
            ['cost', 'integer'],
        ];
    }
}