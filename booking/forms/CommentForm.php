<?php


namespace booking\forms;

use yii\base\Model;

class CommentForm extends Model
{
    public $text;
    public $captcha;
//TODO Сделать Капчу
    public function rules()
    {
        return [
            [['text'], 'required', 'message' => 'Обязательное поле'],
            ['text', 'string'],
        ];
    }
}