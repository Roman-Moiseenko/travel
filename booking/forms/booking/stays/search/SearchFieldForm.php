<?php


namespace booking\forms\booking\stays\search;


use yii\base\Model;

class SearchFieldForm extends Model
{
    public $name;
    public $checked;
    public $id;
    private $_formName;

    public function __construct($formName, $id, $name, $checked, $config = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->checked = $checked;
        $this->_formName = $formName;
        parent::__construct($config);
    }

    public function formName() {
        return $this->_formName;
    }

    public function rules()
    {
        return [
            ['checked', 'safe'],
            ['name', 'safe'],
            ['id', 'safe'],
        ];
    }
}