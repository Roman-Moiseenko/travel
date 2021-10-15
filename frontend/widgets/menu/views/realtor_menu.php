<?php

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;


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
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/realtor' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor'])) ?>">
                        <i class="fas fa-user-tie"></i>
                        &#160;<?= Lang::t('Агентство') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/landowners' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor/landowners'])) ?>">
                        <i class="fas fa-layer-group"></i>
                        &#160;<?= Lang::t('Участки') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/investment' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor/investment'])) ?>">
                        <i class="fas fa-search-dollar"></i>
                        &#160;<?= Lang::t('Инвестиции') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/map' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor/map'])) ?>">
                        <i class="far fa-map"></i>
                        &#160;<?= Lang::t('Карта земли') ?></a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link"
                       href="<?= Html::encode(Url::to(['/forum/zemlya-nedvizhimost-stroitelstvo'])) ?>">
                        <i class="far fa-question-circle"></i>&#160;<?= Lang::t('Форум') ?></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

