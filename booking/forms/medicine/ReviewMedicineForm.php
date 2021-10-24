<?php


namespace booking\forms\medicine;


use yii\base\Model;

class ReviewMedicineForm extends Model
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