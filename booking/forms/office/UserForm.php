<?php


namespace booking\forms\office;


use booking\entities\office\User;
use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $email;
    public $_user;
    public $role;
    public $password;
    public $id;

    public function __construct(User $user = null, $config = [])
    {
        if ($user) {
            $this->username = $user->username;
            $this->email = $user->email;
            $roles = \Yii::$app->authManager->getRolesByUser($user->id);
            $this->role = $roles ? reset($roles)->name : null;
            $this->_user = $user;
            $this->password = '';
        } else {
            $this->_user = new User();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'role'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            ['password', 'string', 'min' => 6],
        ];
    }
}