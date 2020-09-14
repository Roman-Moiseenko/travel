<?php

use booking\entities\Lang;
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
                        <a class="nav-link" href="<?= Url::to(['/cabinet/dialogs']) ?>" title="<?= Lang::t('Сообщения') ?>">
                            <i class="fas fa-envelope"></i><span class="badge badge-danger"><?= MessageHelper::countNew()?></span>
                        </a>
                    </span>
                </li>
            <li class="dropdown nav-item">
                <a href="/index.php" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    <?= Lang::current() ?></a>
                <div class="dropdown-menu">
                    <?php foreach (Lang::listLangs() as $lang): ?>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/cabinet/user/lang', 'lang' => $lang])) ?>"><?= $lang ?></a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="dropdown nav-item">
                <a href="/index.php" class="dropdown-toggle nav-link"
                   data-toggle="dropdown"><?= CurrencyHelper::currentString() ?></a>
                <div class="dropdown-menu">
                    <?php foreach (CurrencyHelper::listCurrency() as $key => $currency): ?>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/cabinet/user/currency', 'currency' => $key])) ?>">
                            <?= $currency ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="nav-item"> <span class="hidden-xs hidden-sm hidden-md"><a class="nav-link"
                                                                                 href="<?= Url::to(['/support']) ?>"><i
                                class="fa fa-phone"></i><?= Lang::t('Служба поддержки') ?></a></span>
            </li>
            <li class="dropdown nav-item"><a href="/index.php?route=account/account"
                                             title="<?= Lang::t('Мой личный кабинет') ?>"
                                             class="dropdown-toggle nav-link" data-toggle="dropdown"><i
                            class="fa fa-user"></i>
                    <span
                            class="hidden-xs hidden-sm hidden-md"><?= Lang::t('Мой личный кабинет') ?></span> <span
                            class="caret"></span></a>
                <div class="dropdown-menu">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>"><?= Lang::t('Войти') ?></a>
                        <a class="dropdown-item"
                           href="<?= Html::encode(Url::to(['/auth/signup'])) ?>"><?= Lang::t('Регистрация') ?></a>
                    <?php else: ?>
                        <?= UserMenuWidget::widget([
                            'type' => UserMenuWidget::TOP_USERMENU,
                            'class_list' => 'dropdown-item',
                        ]) ?>
                    <?php endif; ?>
                </div>
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
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'stays/stays' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['/stays'])) ?>">
                        <i class="fas fa-hotel"></i>
                        &#160;<?= Lang::t('Жилье') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'cars/cars' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['/cars'])) ?>">
                        <i class="fas fa-car"></i>
                        &#160;<?= Lang::t('Авто')?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'tours/tours' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['/tours'])) ?>" >
                        <i class="fas fa-map-marked-alt"></i>
                        &#160;<?= Lang::t('Туры') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'tickets/tickets' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['/tickets'])) ?>">
                        <i class="fas fa-ticket-alt"></i>
                        &#160;<?= Lang::t('Билеты') ?></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

