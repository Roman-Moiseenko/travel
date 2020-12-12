<?php

use booking\entities\admin\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Здравствуйте <?= Html::encode($user->username) ?>,</p>
    <p>Вы зарегистрировались на портале бронирования туристических услуг ООО "Кёнигс.РУ"</p>
    <p>Вам необходимо:</p>
    <p> - подтвердить свою электронную почту: <?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
    <p> - заполнить свой личный кабинет и добавить организацию (ЮрЛицо, ИП, самозанятые)</p>
    <p> - заключить с нами договор <a href="https://static.koenigs.ru/files/docs/dogovor_provider_agregator.docx" download>(Скачать)</a> и отправить заполненный Вашими реквизитами по адресу <a href="mailto:provider@koenigs.ru">provider@koenigs.ru</a> </p>
</div>
