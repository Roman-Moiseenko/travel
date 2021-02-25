<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\comfort\AssignComfort;
use booking\entities\booking\stays\comfort\Comfort;
use yii\base\Model;

class AssignComfortForm extends Model
{
    public $comfort_id;
    public $pay;
    public $photo_id;
    public $_comfort;

    public function __construct(Comfort $comfort, AssignComfort $assignComfort = null, $config = [])
    {
        $this->_comfort = $comfort;
        if ($assignComfort) {
            $this->comfort_id = $assignComfort->comfort_id;
            $this->pay = $assignComfort->pay;
            $this->photo_id = $assignComfort->photo_id;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['comfort_id', 'photo_id'], 'integer'],
            ['pay', 'boolean'],
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