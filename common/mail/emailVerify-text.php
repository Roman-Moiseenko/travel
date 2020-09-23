<?php

/* @var $this yii\web\View */
/* @var $user User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/verify-email', 'token' => $user->verification_token]);

use booking\entities\admin\User; ?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
