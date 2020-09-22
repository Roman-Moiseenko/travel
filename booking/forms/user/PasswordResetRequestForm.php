<?php
namespace booking\forms\user;


use booking\entities\Lang;
use booking\entities\user\User;
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
                'targetClass' => '\booking\entities\user\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Lang::t('Пользователь с таким email существует'),
            ],
        ];
    }

}
