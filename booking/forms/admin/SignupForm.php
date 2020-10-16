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
    public $offer;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Обязательное поле'],
            ['username', 'unique', 'targetClass' => '\booking\entities\admin\User', 'message' => 'Имя пользователя уже занято'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Обязательное поле'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\booking\entities\admin\User', 'message' => 'Данный email уже используется'],

            ['password', 'required', 'message' => 'Обязательное поле'],
            ['password', 'string', 'min' => 6, 'message' => 'Минимальное кол-во знаков - 6'],

           // ['agreement', 'required'],
            ['agreement', 'boolean'],
            ['agreement', 'compare', 'compareValue' => true, 'operator' => '==', 'message' => 'Необходимо согласие'],

            ['offer', 'boolean'],
            ['offer', 'compare', 'compareValue' => true, 'operator' => '==', 'message' => Lang::t('Необходимо согласие')],
        ];
    }

}
