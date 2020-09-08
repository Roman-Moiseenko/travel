<?php

use booking\entities\Currency;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\MessageHelper;
use booking\helpers\UserHelper;
use frontend\widgets\UserMenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container">
    <div id="top-links">
        <ul class="nav justify-content-end">
                <li class="nav-item">
                    <span class="hidden-xs hidden-sm hidden-md">
                        <a class="nav-link" href="<?= Url::to(['/cabinet/dialog/index']) ?>" title="<?= Lang::t('Сообщения') ?>">
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
                                                                                 href="<?= Url::to(['/contact']) ?>"><i
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
    <nav id="menu" class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Html::encode(Url::to(['site/index'])) ?>"><i
                                class="fas fa-hotel">&#160;<?= Lang::t('Жилье') ?></i></a>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= Html::encode(Url::to(['/cars'])) ?>"><i
                                class="fas fa-car">&#160;<?= Lang::t('Авто') ?></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= Html::encode(Url::to(['/tours'])) ?>"><i
                                class="fas fa-map-marked-alt">&#160;<?= Lang::t('Туры') ?></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= Html::encode(Url::to(['/tickets'])) ?>"><i
                                class="fas fa-ticket-alt">&#160;<?= Lang::t('Билеты') ?></i></a></li>
            </ul>

        </div>
    </nav>
</div>

