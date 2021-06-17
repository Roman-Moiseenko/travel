<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\trips\Trip;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TripTypeForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(Trip $trip = null, $config = [])
    {
        if ($trip) {
            $this->main = $trip->type_id;
            $this->others = ArrayHelper::getColumn($trip->typeAssignments, 'type_id');
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