<?php


namespace booking\forms\forum;


use booking\entities\forum\Message;
use yii\base\Model;

class MessageForm extends Model
{
    public $text;

    public function __construct(Message $message = null, $config = [])
    {
        if ($message) {
            $this->text = $message->text;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['text'], 'string'],
            [['text'], 'required', 'message' => 'Обязательное поле'],
        ];
    }
}