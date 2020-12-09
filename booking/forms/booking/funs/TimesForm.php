<?php


namespace booking\forms\booking\funs;


use booking\entities\booking\funs\Times;
use yii\base\Model;

class TimesForm extends Model
{
    public $begin;
    public $end;

    public function __construct(Times $times = null, $config = [])
    {
        if ($times) {
            $this->begin = $times->begin;
            $this->end = $times->end;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['begin', 'end'], 'string'],
        ];
    }
}