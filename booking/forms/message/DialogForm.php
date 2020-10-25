<?php


namespace booking\forms\message;


use booking\entities\Lang;
use yii\base\Model;

class DialogForm extends Model
{
    public $theme_id;
    public $text;

    public function rules()
    {
        return [
            [['theme_id'], 'required', 'message' => Lang::t('Выберите тему сообщения')],
            [['text'], 'required', 'message' => Lang::t('Напишите сообщение')],
            ['theme_id', 'integer'],
            ['text', 'string'],
        ];
    }

}