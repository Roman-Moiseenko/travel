<?php


namespace booking\forms\moving;


use yii\base\Model;

class AnswerForm extends Model
{
    public $answer;

    public function rules()
    {
        return [
            ['answer', 'string'],
            ['answer', 'required', 'message' => 'Обязательное поле'],
        ];
    }
}