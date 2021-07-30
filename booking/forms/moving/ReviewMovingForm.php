<?php


namespace booking\forms\moving;


use booking\entities\booking\BaseReview;
use booking\entities\Lang;
use booking\entities\moving\ReviewMoving;
use yii\base\Model;

class ReviewMovingForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            [['text'], 'required', 'message' => 'Обязательное поле'],
            ['text', 'string'],
        ];
    }
}