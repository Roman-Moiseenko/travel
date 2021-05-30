<?php


/* @var $this \yii\web\View */

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>" class="list-group-item"><?= Lang::t('Вход') ?></a>
<a href="<?= Html::encode(Url::to(['/signup'])) ?>"
   class="list-group-item"><?= Lang::t('Регистрация') ?></a>
