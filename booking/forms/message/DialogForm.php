<?php


namespace booking\forms\message;


use yii\base\Model;

class DialogForm extends Model
{
    public $theme_id;
    public $text;

    public function rules()
    {
        return [
            [['theme_id', 'text'], 'required'],
            ['theme_id', 'integer'],
            ['text', 'string'],
        ];
    }

}