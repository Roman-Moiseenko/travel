<?php


namespace booking\forms\admin;


use booking\entities\admin\user\User;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
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
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => 'Нет пользователя с таким email',
            ],
        ];
    }

}
