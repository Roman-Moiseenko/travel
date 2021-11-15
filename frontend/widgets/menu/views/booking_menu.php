<?php

use booking\entities\Lang;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $user User */

?>


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
                        &#160;<?= Lang::t('Экскурсии') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'funs/funs' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/funs'])) ?>">
                        <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_FUNS) ?>
                        &#160;<?= Lang::t('Отдых') ?></a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'stays/stays' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/stays'])) ?>">
                        <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_STAY) ?>
                        &#160;<?= Lang::t('Проживание') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'cars/cars' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/cars'])) ?>">
                        <?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_CAR) ?>
                        &#160;<?= Lang::t('Авто') ?>
                    </a>
                </li>
                    <li class="nav-item">
                        <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'food' ? 'active' : '' ?>"
                           href="<?= Html::encode(Url::to(['/foods'])) ?>">
                        <span class="d2-badge d2-badge-success"><?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_FOOD) ?>
                        &#160;<?= Lang::t('Где поесть') ?></span>
                        </a>
                    </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'shops/shops' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/shops'])) ?>">
                        <span class="d2-badge d2-badge-warning"><?= BookingHelper::icons(BookingHelper::BOOKING_TYPE_SHOP) ?>
                        &#160;<?= Lang::t('Shop') ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

