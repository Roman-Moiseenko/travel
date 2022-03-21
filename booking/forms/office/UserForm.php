<?php


namespace booking\forms\office;


use booking\entities\office\User;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\manage\FullNameForm;
use yii\base\Model;
/**
 *
 * @property PhotosForm $photo
 * @property FullNameForm $person
 */
class UserForm extends CompositeForm
{
    public $username;
    public $email;
    public $_user;
    public $role;
    public $password;
    public $id;
    public $home_page;
    public $description;

    public function __construct(User $user = null, $config = [])
    {
        if ($user) {
            $this->home_page = $user->home_page;
            $this->description = $user->description;
            $this->username = $user->username;
            $this->email = $user->email;
            $roles = \Yii::$app->authManager->getRolesByUser($user->id);
            $this->role = $roles ? reset($roles)->name : null;
            $this->_user = $user;
            $this->password = '';
            $this->person = new FullNameForm($user->person);

        } else {
            $this->_user = new User();
            $this->person = new FullNameForm();
        }
        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'role'], 'required', 'message' => 'Заполните это поле'],
            [['home_page', 'description'], 'string'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            ['password', 'string', 'min' => 6],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo', 'person'];
    }
}