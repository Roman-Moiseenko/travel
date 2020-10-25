<?php


namespace booking\forms\message;


use booking\entities\Lang;
use yii\base\Model;

class ConversationForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            ['text', 'required', 'message' => Lang::t('Обязательное поле')],
            ['text', 'string'],
        ];
    }

}