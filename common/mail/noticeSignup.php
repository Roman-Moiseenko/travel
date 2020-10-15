<?php

use booking\entities\admin\User;
use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user User */

?>
<div class="verify-email">
    <p><?= Lang::t('Здравствуйте') . ' ' . Html::encode($user->username) ?>,</p>

    <p><?= Lang::t('Вы зарегистрировались на') . ' ' . \Yii::$app->params['frontendHostInfo'] ?></p>
    <p><?= Lang::t('Настройте свой') . Html::a('личный кабинет', Url::to(['category/profile', 'id' => $user->id]))?></p>

    <p><?= Lang::t('И бронируйте сулуги, жилье и авто нашем сервисе') ?></p>
</div>
