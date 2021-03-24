<?php

use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\MessageHelper;
use frontend\widgets\UserMenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container">
    <div id="top-links">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                    <span class="hidden-xs hidden-sm hidden-md">
                        <a class="nav-link" href="<?= Url::to(['/cabinet/dialogs']) ?>"
                           title="<?= Lang::t('Сообщения') ?>" rel="nofollow">
                            <i class="fas fa-envelope"></i><span
                                    class="badge badge-danger"><?= MessageHelper::countNew() ?></span>
                        </a>
                    </span>
            </li>
            <li class="dropdown nav-item">
                <a href="/index.php" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                   aria-haspopup="true" aria-expanded="false" rel="nofollow">
                    <?= Lang::current() ?></a>
                <div class="dropdown-menu">
                    <?php foreach (Lang::listLangs() as $lang): ?>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/', 'lang' => $lang])) ?>" rel="nofollow"><?= $lang ?></a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="dropdown nav-item">
                <a href="/index.php" class="dropdown-toggle nav-link"
                   data-toggle="dropdown" rel="nofollow"><?= CurrencyHelper::currentString() ?></a>
                <div class="dropdown-menu">
                    <?php foreach (CurrencyHelper::listCurrency() as $key => $currency): ?>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/cabinet/user/currency', 'currency' => $key])) ?>">
                            <?= $currency ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="nav-item">
                <span class="hidden-xs hidden-sm hidden-md">
                    <a class="nav-link" href="<?= Url::to(['/support']) ?>" title="<?= Lang::t('Служба поддержки') ?>" rel="nofollow">
                        <i class="far fa-question-circle"></i>
                    </a>
                </span>
            </li>
            <li class="dropdown nav-item">
                <?php if (Yii::$app->user->isGuest): ?>
                    <a href="" title="<?= Lang::t('Войти') ?>" class="dropdown-toggle nav-link" data-toggle="dropdown" rel="nofollow"><i class="fas fa-sign-in-alt"></i> <?= Lang::t('Войти') ?></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item"
                       href="<?= Html::encode(Url::to(['/login'])) ?>" rel="nofollow"><?= Lang::t('Войти') ?></a>
                    <a class="dropdown-item"
                       href="<?= Html::encode(Url::to(['/signup'])) ?>" rel="nofollow"><?= Lang::t('Регистрация') ?></a>
                </div>
                <?php else: ?>
                <a href="" title="<?= Lang::t('Мой личный кабинет') ?>" class="dropdown-toggle nav-link" data-toggle="dropdown" rel="nofollow">
                    <i class="fa fa-user"></i>
                    <span class="hidden-xs hidden-sm hidden-md">
                        <?=  \Yii::$app->user->identity->personal->fullname->isEmpty() ? \Yii::$app->user->identity->username : \Yii::$app->user->identity->personal->fullname->getShortname()?>
                    </span> <span class="caret"></span>
                </a>
                    <div class="dropdown-menu">
                        <?= UserMenuWidget::widget([
                            'type' => UserMenuWidget::TOP_USERMENU,
                            'class_list' => 'dropdown-item',
                        ]) ?>
                    </div>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>
<div class="container">
    <nav id="top-menu" class="navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="top-menu-a mt-1 nav-link"
                       href="<?= Html::encode(Url::to(['/'])) ?>" title="<?= Lang::t('На главную') ?>">
                        <i class="fas fa-bars"></i>&#160;
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'tours/tours' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/tours'])) ?>">
                        <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_TOUR) ?>
                        &#160;<?= Lang::t('Туры') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'funs/funs' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/funs'])) ?>">
                        <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_FUNS) ?>
                        &#160;<?= Lang::t('Отдых') ?></a>
                </li>
                <?php //TODO Жилье ?>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'stays/stays' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/stays'])) ?>">
                        <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_STAY) ?>
                        &#160;<?= Lang::t('Жилье') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'cars/cars' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/cars'])) ?>">
                        <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_CAR) ?>
                        &#160;<?= Lang::t('Авто') ?>

                    </a>
                </li>
                <!--li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'tickets/tickets' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/tickets'])) ?>">
                       <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_TICKET) ?>
                        &#160;<?= Lang::t('Билеты') ?></a>
                </li-->

            </ul>
        </div>
    </nav>
</div>

