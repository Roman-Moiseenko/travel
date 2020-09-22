<?php
namespace booking\forms\office;

use booking\entities\office\User;
use yii\base\Model;


/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\booking\entities\office\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Пользователь с таким email существует'
            ],
        ];
    }

}
