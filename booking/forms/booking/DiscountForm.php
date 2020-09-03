<?php


namespace booking\forms\booking;


use yii\base\Model;

class DiscountForm extends Model
{
    public $entities;
    public $entities_id;
    public $percent;
    public $count;

    public function rules()
    {
        return [
            [['entities', 'percent', 'count'], 'required'],
            [['entities_id', 'percent', 'count'], 'integer'],
            [['entities'], 'string'],
        ];
    }
}