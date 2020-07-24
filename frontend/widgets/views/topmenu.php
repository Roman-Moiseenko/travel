<?php

use booking\entities\Currency;
use booking\entities\Lang;
use booking\helpers\UserHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container">
    <div id="top-links" class="nav pull-left">ЛОГОТИП</div>
    <div id="top-links" class="nav pull-right">
        <ul class="list-inline">
            <li class="dropdown">
                <a href="/index.php" class="dropdown-toggle" data-toggle="dropdown"><?= Lang::current() ?></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <?php foreach (UserHelper::listLangs() as $lang): ?>
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/user/lang', 'lang' => $lang])) ?>">
                                <?= $lang ?>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li class="dropdown">
                <a href="/index.php" class="dropdown-toggle" data-toggle="dropdown"><?= UserHelper::Currency(Currency::current()) ?></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <?php foreach (UserHelper::listCurrency() as $key => $currency): ?>
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/user/currency', 'currency' => $key])) ?>">
                                <?= $currency ?>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li> <span class="hidden-xs hidden-sm hidden-md"><a
                            href="<?= Url::to(['/contact']) ?>"><i class="fa fa-phone"></i><?= Lang::t('Служба поддержки') ?></a></span>
            </li>
            <li class="dropdown"><a href="/index.php?route=account/account" title="<?= Lang::t('Мой личный кабинет') ?>"
                                    class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span
                            class="hidden-xs hidden-sm hidden-md"><?= Lang::t('Мой личный кабинет') ?></span> <span
                            class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li><a href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>"><?= Lang::t('Войти') ?></a>
                        </li>
                        <li><a href="<?= Html::encode(Url::to(['/auth/signup'])) ?>"><?= Lang::t('Регистрация') ?></a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>"><?= Lang::t('Мой личный кабинет') ?></a>
                        </li>
                        <li>
                            <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>"><?= Lang::t('Бронирования') ?></a>
                        </li>
                        <li>
                            <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>"><?= Lang::t('Избранное') ?></a>
                        </li>
                        <li>
                            <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>"><?= Lang::t('Мои отзывы') ?></a>
                        </li>
                        <li>
                            <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>"><?= Lang::t('Служба поддержки') ?></a>
                        </li>
                        <li>
                            <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>"><?= Lang::t('Настройки') ?></a>
                        </li>
                        <li><a href="<?= Html::encode(Url::to(['/auth/auth/logout'])) ?>"
                               data-method="post"><?= Lang::t('Выйти') ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
            <li><a href="<?= Url::to(['/shop/cart/index']) ?>" title="Корзина"><i class="fa fa-shopping-cart"></i> <span
                            class="hidden-xs hidden-sm hidden-md">Бронирование (?)</span></a></li>
        </ul>
    </div>
</div>


<div class="container">
    <nav id="menu" class="navbar">
        <div class="navbar-header">
            <span id="category" class="visible-xs"><?= Lang::t('Меню') ?></span>
            <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?= Html::encode(Url::to(['site/index'])) ?>"><i class="fas fa-hotel"></i>&#160;<?= Lang::t('Жилье') ?></a></li>
                <li><a href="<?= Html::encode(Url::to(['/cars'])) ?>"><i class="fas fa-car"></i>&#160;<?= Lang::t('Авто') ?></a></li>
                <li><a href="<?= Html::encode(Url::to(['/tours'])) ?>"><i class="fas fa-map-marked-alt"></i>&#160;<?= Lang::t('Туры') ?></a></li>
                <li><a href="<?= Html::encode(Url::to(['/tickets'])) ?>"><i class="fas fa-ticket-alt"></i>&#160;<?= Lang::t('Билеты') ?></a></li>
            </ul>
        </div>
    </nav>
</div>