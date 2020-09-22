<?php


namespace booking\forms\user;


use booking\entities\Lang;
use booking\entities\user\User;
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
                'targetClass' => '\booking\entities\user\User',
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => Lang::t('Нет пользователя с таким email'),
            ],
        ];
    }

}
