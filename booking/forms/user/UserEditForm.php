<?php


namespace booking\forms\user;


use booking\entities\Lang;
use booking\entities\user\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $_user;
    public $password;
    public $password2;
    public $id;

    public function __construct(User $user, $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->_user = $user;
        $this->password = '';
        $this->password2 = '';
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email'], 'required','message' => Lang::t('Обязательное поле')],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            ['password', 'string', 'min' => 4],
            [['password', 'password2'], 'string', 'min' => 4],
            [
                'password2', 'compare', 'compareAttribute' => 'password',
                'message' => Lang::t('Пароли не совпадают'),
            ],
        ];
    }

}