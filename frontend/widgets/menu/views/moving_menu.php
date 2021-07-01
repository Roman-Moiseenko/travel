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
                    <a class="top-menu-a nav-link <?= isset($this->params['pages']) ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/info'])) ?>">
                        <i class="fas fa-info-circle"></i>&#160;<?= Lang::t('Информация') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/realty' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/realty'])) ?>">
                        <i class="far fa-building"></i>&#160;<?= Lang::t('Недвижимость') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/faq' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/faq'])) ?>">
                        <i class="far fa-question-circle"></i>&#160;<?= Lang::t('Форум') ?></a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/land' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/land'])) ?>">
                        <i class="fas fa-layer-group"></i>&#160;<?= Lang::t('Участки') ?></a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/bussines' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/bussines'])) ?>">
                        <i class="fas fa-business-time"></i>&#160;<?= Lang::t('Бизнес') ?></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

