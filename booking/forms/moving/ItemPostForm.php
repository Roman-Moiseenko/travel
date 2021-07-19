<?php


namespace booking\forms\moving;


use yii\base\Model;

class ItemPostForm extends Model
{
    public $firstname;
    public $surname;
    public $message;

    public function rules()
    {
        return [
            [['firstname', 'surname', 'message'], 'string'],
        ];
    }

    public function clear()
    {
        $this->firstname = '';
        $this->surname = '';
        $this->message = '';
    }


}