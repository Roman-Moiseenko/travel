<?php


namespace booking\forms\booking\tours;

use booking\entities\booking\tours\Extra;
use yii\base\Model;

class ExtraForm extends Model
{
    public $name;
    public $description;
    public $cost;
    public $name_en;
    public $description_en;

    public function __construct(Extra $extra = null, $config = [])
    {
        if ($extra) {
            $this->name = $extra->name;
            $this->description = $extra->description;
            $this->cost = $extra->cost;

            $this->name_en = $extra->name_en;
            $this->description_en = $extra->description_en;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description', 'name_en', 'description_en'], 'string'],
            ['name', 'required', 'message' => 'Обязательное поле'],
            ['cost', 'integer'],
        ];
    }
}