<?php


namespace booking\forms\booking\funs;


use booking\entities\booking\funs\Fun;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class FunExtraForm extends Model
{
    public $assign = [];

    public function __construct(Fun $tour, $config = [])
    {
        $this->assign = ArrayHelper::getColumn($tour->extraAssignments, 'extra_id');
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['assign', 'each', 'rule' => ['integer']],
        ];
    }
}