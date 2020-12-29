<?php

use booking\entities\admin\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/reset/reset', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Здравствуйте <?= Html::encode($user->username) ?>,</p>

    <p>Сбросить пароль:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
