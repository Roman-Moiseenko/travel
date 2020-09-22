<?php
namespace booking\forms\office;

use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\booking\entities\office\User', 'message' => 'Имя пользователя уже занято'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\booking\entities\office\User', 'message' => 'Данный email уже используется'],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }

}
