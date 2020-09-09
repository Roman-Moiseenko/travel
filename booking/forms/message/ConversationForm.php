<?php


namespace booking\forms\message;


use yii\base\Model;

class ConversationForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            ['text', 'required'],
            ['text', 'string'],
        ];
    }

}