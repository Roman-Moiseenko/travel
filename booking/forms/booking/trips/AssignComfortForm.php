<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\trips\placement\AssignComfort;
use yii\base\Model;

class AssignComfortForm extends Model
{
    public $comfort_id;
//    public $pay;
//    public $file;
    public $_assignComfort;
    public $_comfort;
    public $_index;
    public $checked;


    public function __construct(Comfort $comfort, $index, AssignComfort $assignComfort = null, $config = [])
    {
        $this->_comfort = $comfort;
        $this->_index = $index;
        $this->comfort_id = $comfort->id;
        if ($assignComfort) {
//            $this->pay = $assignComfort->pay;
            $this->checked = true;
            $this->_assignComfort = $assignComfort;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['comfort_id'], 'integer'],
//            ['pay', 'boolean'],
//            ['file', 'image'],
            ['checked', 'boolean'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'value' => $this->_comfort->name,
        ];
    }
    public function getId(): int
    {
        return $this->_comfort->id;
    }

}