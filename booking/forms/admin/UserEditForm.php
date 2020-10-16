<?php


namespace booking\forms\admin;

use booking\entities\admin\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $_user;
    public $password;
    public $id;

    public function __construct(User $user, $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->_user = $user;
        $this->password = '';
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email'], 'required', 'message' => 'Обязательное поле'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'Такой пользователь уже имеется'],
            ['password', 'string', 'min' => 6],
        ];
    }

}