<?php
namespace booking\forms\user;

use booking\entities\Lang;
use yii\base\Model;
use booking\entities\user\User;

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
            ['username', 'required', 'message' => Lang::t('Обязательно для заполнения')],
            ['username', 'unique', 'targetClass' => '\booking\entities\user\User', 'message' => Lang::t('Имя пользователя уже занято')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => Lang::t('Обязательно для заполнения')],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\booking\entities\user\User', 'message' =>  Lang::t('Данный email уже используется')],

            ['password', 'required', 'message' => Lang::t('Обязательно для заполнения, длина не менее 6 символов')],
            ['password', 'string', 'min' => 6],
            //['password', 'message' => Lang::t('Обязательно для заполнения, длина не менее 6 символов')],

         //   ['agreement', 'required'],
            ['agreement', 'boolean'],
            ['agreement', 'compare', 'compareValue' => true, 'operator' => '==', 'message' => Lang::t('Необходимо согласие')],

        ];
    }

}
