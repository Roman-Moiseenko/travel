<?php


namespace booking\forms\admin;


use booking\entities\admin\User;

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
            ['email', 'required', 'message' => 'Обязательное поле'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\booking\entities\admin\User',
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => 'Нет пользователя с таким email',
            ],
        ];
    }

}
