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
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/moving' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving'])) ?>">
                        <i class="fas fa-info-circle"></i>&#160;<?= Lang::t('На ПМЖ') ?>
                    </a>
                </li>
                <!--li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/realty' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/realty'])) ?>">
                        <i class="far fa-building"></i>&#160;<?= Lang::t('Недвижимость') ?>
                    </a>
                </li-->
                <!--li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/land' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/land'])) ?>">
                        <i class="fas fa-layer-group"></i>&#160;<?= Lang::t('Куда переехать') ?></a>
                </li-->
                <!--li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/build' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/build'])) ?>">
                        <i class="fas fa-hard-hat"></i>&#160;<?= Lang::t('Строительство') ?></a>
                </li-->
<!-- --------------------------------------- -->
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/education' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/education'])) ?>">
                        <i class="fas fa-graduation-cap"></i>&#160;<?= Lang::t('Образование') ?></a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'moving/medicine' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/moving/medicine'])) ?>">
                        <i class="fas fa-heartbeat"></i>&#160;<?= Lang::t('Медицина') ?></a>
                </li>
<!-- --------------------------------------- -->
                <li class="nav-item">
                    <a class="top-menu-a nav-link"
                       href="<?= Html::encode(Url::to(['/forum/pereezd-na-pmzh'])) ?>">
                        <i class="far fa-question-circle"></i>&#160;<?= Lang::t('Форум') ?></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

