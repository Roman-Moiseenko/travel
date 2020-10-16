<?php


namespace booking\forms\booking;


use yii\base\Model;

class ConfirmationForm extends Model
{
    public $confirmation;

    public function rules()
    {
        return [
            [['confirmation'], 'required', 'message' => 'Обязательное поле'],
            [['confirmation'], 'string'],
        ];
    }
}