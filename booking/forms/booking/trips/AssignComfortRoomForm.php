<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\trips\placement\AssignComfort;
use booking\entities\booking\trips\placement\room\AssignComfortRoom;
use yii\base\Model;

class AssignComfortRoomForm extends Model
{
    public $comfort_id;
    public $_assignComfort;
    public $_comfort;
    public $_index;
    public $checked;


    public function __construct(ComfortRoom $comfort, $index, AssignComfortRoom $assignComfort = null, $config = [])
    {
        $this->_comfort = $comfort;
        $this->_index = $index;
        $this->comfort_id = $comfort->id;
        if ($assignComfort) {
            $this->checked = true;
            $this->_assignComfort = $assignComfort;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['comfort_id'], 'integer'],
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