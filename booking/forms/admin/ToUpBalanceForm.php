<?php


namespace booking\forms\admin;


use yii\base\Model;

class ToUpBalanceForm extends Model
{

    public $amount;

    public function rules()
    {
        return [
            [['amount'], 'integer'],
            ['amount', 'required'],
        ];
    }
}