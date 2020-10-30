<?php

use booking\entities\admin\User;
use booking\entities\booking\ReviewInterface;
use yii\web\IdentityInterface;

/* @var $user IdentityInterface */

$url = \Yii::$app->params['adminHostInfo'];

if ($user instanceof User) {$provider = true;}
else {$provider = false;}
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td colspan="2">
                <h2>Регистрация нового <?= $provider ? 'Провайдера' : 'Клиента' ?></span></h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%">Username</td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= $user->username ?>

            </td>
        </tr>
        <tr>
            <td style="width: 25%">Email</td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= $user->email ?>

            </td>
        </tr>
    </table>
</div>
