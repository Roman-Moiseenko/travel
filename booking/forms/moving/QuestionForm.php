<?php


namespace booking\forms\moving;


use yii\base\Model;

class QuestionForm extends Model
{
    public $username;
    public $email;
    public $question;

    public function rules()
    {
        return [
            [['username', 'email', 'question'], 'string'],
            [['username', 'question'], 'required', 'message' => 'Обязательное поле'],
        ];
    }
}