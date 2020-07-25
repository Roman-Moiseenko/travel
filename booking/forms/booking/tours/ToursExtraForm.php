<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\Tours;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ToursExtraForm extends Model
{
    public $assign = [];

    public function __construct(Tours $tour, $config = [])
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