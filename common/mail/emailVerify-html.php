<?php

use booking\entities\admin\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Здравствуйте <?= Html::encode($user->username) ?>,</p>

    <p>Ссылка для подтверждения почты:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
