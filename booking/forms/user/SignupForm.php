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
           // ['username', 'required', 'message' => Lang::t('Обязательно для заполнения')],
            ['username', 'unique', 'targetClass' => '\booking\entities\user\User', 'message' => Lang::t('Номер телефона уже используется')],
            ['username', 'string', 'min' => 10, 'max' => 13],
            ['username', 'match', 'pattern' => '/^[+][0-9]*$/i', 'message' => Lang::t('Неверный номер телефона')],
            ['username', 'required', 'message' => Lang::t('Заполните это поле')],

            ['email', 'trim'],
            ['email', 'required', 'message' => Lang::t('Заполните это поле')],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\booking\entities\user\User', 'message' =>  Lang::t('Email уже используется')],

            ['password', 'string', 'min' => 6, 'message' => Lang::t('Не менее 6 символов')],
            ['password', 'required', 'message' => Lang::t('Заполните это поле')],

            [['agreement', 'policy'], 'boolean'],
            [['agreement', 'policy'], 'compare', 'compareValue' => true, 'operator' => '==', 'message' => Lang::t('Необходимо согласие')],



            [['surname', 'firstname', 'secondname'], 'string', 'max' => 33],
            [['surname', 'firstname'], 'required', 'message' => Lang::t('Заполните это поле')],
        ];
    }

}
