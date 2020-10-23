<?php


namespace booking\forms\blog;


use booking\entities\Lang;
use yii\base\Model;

class CommentForm extends Model
{
    public $parentId;
    public $text;

    public function rules()
    {
        return [
            [['text'], 'required', 'message' => Lang::t('Обязательное поле')],
            ['text', 'string'],
            ['parentId', 'integer'],
        ];
    }
}