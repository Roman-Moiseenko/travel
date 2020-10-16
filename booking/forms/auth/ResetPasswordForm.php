<?php
namespace booking\forms\auth;

use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password'], 'required', 'message' => 'Обязательное поле'],
            ['password', 'string', 'min' => 6, 'message' => 'Минимальное кол-во знаков - 6'],
        ];
    }

}
