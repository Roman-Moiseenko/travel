<?php


namespace booking\forms\office;

use booking\entities\office\User;
use yii\base\Model;

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
                'targetClass' => '\booking\entities\office\User',
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => 'Нет пользователя с таким email',
            ],
        ];
    }

}
