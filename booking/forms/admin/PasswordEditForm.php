<?php


namespace booking\forms\admin;


use yii\base\Model;

class PasswordEditForm extends Model
{
    public $password;
    public $password2;

    public function rules()
    {
        return [
            [['password', 'password2'], 'required', 'message' => 'Обязательное поле'],
            [['password', 'password2'], 'string', 'min' => 6, 'message' => 'Минимальное кол-во знаков - 6'],
            [
                'password2', 'compare', 'compareAttribute' => 'password',
                'message' => "Пароли не совпадают",
            ],
        ];
    }

}