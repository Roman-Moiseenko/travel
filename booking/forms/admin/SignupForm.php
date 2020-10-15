<?php
namespace booking\forms\admin;

use booking\entities\Lang;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $agreement;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\booking\entities\admin\User', 'message' => 'Имя пользователя уже занято'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\booking\entities\admin\User', 'message' => 'Данный email уже используется'],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],

           // ['agreement', 'required'],
            ['agreement', 'boolean'],
            ['agreement', 'compare', 'compareValue' => true, 'operator' => '==', 'message' => 'Необходимо согласие'],
        ];
    }

}
