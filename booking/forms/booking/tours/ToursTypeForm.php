<?php


namespace booking\forms\booking\tours;

use booking\entities\booking\tours\Tours;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ToursTypeForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(Tours $tour = null, $config = [])
    {
        if ($tour) {
            $this->main = $tour->type_id;
            $this->others = ArrayHelper::getColumn($tour->typeAssignments, 'type_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['main', 'required'],
            ['main', 'integer'],
            ['others', 'each', 'rule' => ['integer']],
        ];
    }

    public function beforeValidate(): bool
    {
        $this->others = array_filter((array)$this->others);
        return parent::beforeValidate();
    }
}