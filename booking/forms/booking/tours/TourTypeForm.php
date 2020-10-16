<?php


namespace booking\forms\booking\tours;

use booking\entities\booking\tours\Tour;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TourTypeForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(Tour $tour = null, $config = [])
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
            ['main', 'required', 'message' => 'Обязательное поле'],
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