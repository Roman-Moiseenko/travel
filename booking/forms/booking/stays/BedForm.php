<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\bedroom\AssignBed;
use booking\entities\booking\stays\bedroom\TypeOfBed;
use yii\base\Model;

class BedForm extends Model
{
    public $bed_id;
    public $count;
    public $_bed;
    public function __construct(TypeOfBed $bed, $count = null, $config = [])
    {
        if ($count) {
            $this->count = $count;
        } else {
        //    $this->count = 0;
        }
        $this->bed_id = $bed->id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['count', 'integer'],
        ];
    }
}