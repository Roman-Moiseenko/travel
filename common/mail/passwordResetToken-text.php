<?php

/* @var $this yii\web\View */
/* @var $user User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

use booking\entities\admin\User;
?>
Здравствуйте <?= $user->username ?>,

Сбросить пароль:

<?= $resetLink ?>
