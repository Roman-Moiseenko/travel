<?php


namespace booking\forms\booking\tours;


use yii\base\Model;

class TransferForm extends Model
{
    public $from_id;
    public $to_id;
    public $cost;

    public function rules()
    {
        return [
            [['from_id', 'to_id', 'cost'], 'integer'],
            [['from_id', 'to_id', 'cost'], 'required', 'message' => 'Обязательное поле'],
        ];
    }
}