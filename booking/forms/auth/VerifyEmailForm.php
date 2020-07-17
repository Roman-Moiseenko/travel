<?php

namespace booking\forms\auth;

use booking\entities\user\User;
use yii\base\Model;

class VerifyEmailForm extends Model
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var User
     */

}
