<?php


namespace booking\forms\booking\stays\rules;


use booking\entities\booking\stays\bedroom\AssignRoom;
use yii\base\Model;

class BedroomsForm extends Model
{
    public $bed_type = [];
    public $bed_count = [];
    public $square;

    public function __construct(AssignRoom $room = null, $config = [])
    {
        if ($room) {
            $this->square = $room->square;
            $beds = $room->assignBeds;
            foreach ($beds as $bed) {
                $this->bed_type[] = $bed->bed_id;
                $this->bed_count[] = $bed->count;
            }
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['square', 'integer', 'min' => 0],
            ['bed_type', 'each', 'rule' => ['integer']],
            ['bed_count', 'each', 'rule' => ['integer']],
        ];
    }
}