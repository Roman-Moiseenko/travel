<?php


namespace booking\forms\office;


use yii\base\Model;

class AltForm extends Model
{
    public $alt;
    public $id;
    public $class_name;

    public function rules()
    {
        return [
            [['alt', 'class_name'], 'string'],
            ['id', 'integer'],
        ];
    }
}