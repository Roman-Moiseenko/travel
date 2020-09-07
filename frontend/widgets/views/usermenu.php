<?php
/* @var $type integer */
/* @var $class string */

use booking\entities\Lang;
use frontend\widgets\UserMenuWidget;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/cabinet/profile/index'])) ?>">
    <?php if ($type === UserMenuWidget::TOP_USERMENU) echo Lang::t('Мой личный кабинет'); ?>
    <?php if ($type === UserMenuWidget::CABINET_USERMENU) echo Lang::t('Профиль'); ?>
</a>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/cabinet/booking/index'])) ?>"><?= Lang::t('Бронирования') ?></a>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/cabinet/wishlist/index'])) ?>"><?= Lang::t('Избранное') ?></a>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/cabinet/review/index'])) ?>"><?= Lang::t('Мои отзывы') ?></a>
<!-- Меню для Кабинета-->
<?php if ($type === UserMenuWidget::CABINET_USERMENU): ?>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/cabinet/messages/index'])) ?>"><?= Lang::t('Сообщения') ?></a>
    <a class="<?= $class ?>"
       href="<?= Html::encode(Url::to(['/cabinet/booking/history'])) ?>"><?= Lang::t('История') ?></a>
<?php endif; ?>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/contacts/message'])) ?>"><?= Lang::t('Служба поддержки') ?></a>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/cabinet/auth'])) ?>"><?= Lang::t('Аутентификация') ?></a>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/cabinet/profile/options'])) ?>"><?= Lang::t('Настройки') ?></a>
<a class="<?= $class ?>"
   href="<?= Html::encode(Url::to(['/auth/auth/logout'])) ?>" data-method="post"><?= Lang::t('Выйти') ?></a>
