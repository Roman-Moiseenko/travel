<?php


namespace booking\forms\check;


use booking\entities\check\User;
use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $fullname;
    public $box_office;
    public $phone;
    public $_user;
    public $role;
    public $password;
    public $id;

    //public $objects = [];

    public function __construct(User $user = null, $config = [])
    {

        if ($user) {
            $this->username = $user->username;
            $this->fullname = $user->fullname;
            $this->box_office = $user->box_office;
            $this->phone = $user->phone;
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
            [['username'], 'required', 'message' => 'Обязательное поле'],
            [['username', 'fullname', 'box_office', 'phone'], 'string', 'max' => 255],
            [['username'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            [['password'], 'string', 'min' => 6, 'message' => 'Не менее 6 символов'],
        ];
    }
}