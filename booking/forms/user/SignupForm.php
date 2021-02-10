<?php
namespace booking\forms\user;

use booking\entities\Lang;
use booking\forms\CompositeForm;
use booking\forms\manage\FullNameForm;
use yii\base\Model;
use booking\entities\user\User;

/**
 * Signup form
 * @property FullNameForm $fullname
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $agreement;
    public $policy;

    public $surname;
    public $firstname;
    public $secondname;

    public $phone;


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

            ['password', 'string', 'min' => 6],
            ['password', 'required', 'message' => Lang::t('Обязательно для заполнения, длина не менее 6 символов')],

            [['agreement', 'policy'], 'boolean'],
            [['agreement', 'policy'], 'compare', 'compareValue' => true, 'operator' => '==', 'message' => Lang::t('Необходимо согласие')],

            ['phone', 'string', 'min' => 10, 'max' => 13],
            ['phone', 'match', 'pattern' => '/^[+][0-9]*$/i'],
            [['phone'], 'required', 'message' => Lang::t('Обязательное поле. Формат +КодСтраныЦифры, например +79990001111')],

            [['surname', 'firstname', 'secondname'], 'string', 'max' => 33],
            [['surname', 'firstname'], 'required'],
        ];
    }

}
