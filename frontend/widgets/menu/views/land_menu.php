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

                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'land/land' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/lands'])) ?>">
                        <i class="fas fa-user-tie"></i>
                        &#160;<?= Lang::t('Агентство') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'land/investment' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/land/investment'])) ?>">
                        <i class="fas fa-search-dollar"></i>
                        &#160;<?= Lang::t('Инвестиции') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'land/map' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/land/map'])) ?>">
                        <i class="far fa-map"></i>
                        &#160;<?= Lang::t('Карта земли') ?></a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'land/add' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/land'])) ?>">
                        <i class="fas fa-layer-group"></i>
                        &#160;<?= Lang::t('Участки') ?>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</div>

