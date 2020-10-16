<?php


namespace booking\forms\blog;


use yii\base\Model;

class CommentForm extends Model
{
    public $parentId;
    public $text;

    public function rules()
    {
        return [
            [['text'], 'required', 'message' => 'Обязательное поле'],
            ['text', 'string'],
            ['parentId', 'integer'],
        ];
    }
}