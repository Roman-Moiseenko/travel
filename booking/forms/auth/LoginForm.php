<?php
namespace booking\forms\auth;

use booking\entities\Lang;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password'], 'required', 'message' => Lang::t('Необходимо ввести пароль')],
            [['username'], 'required', 'message' => Lang::t('Необходимо ввести логин или email')],
            ['rememberMe', 'boolean'],
        ];
    }

}
