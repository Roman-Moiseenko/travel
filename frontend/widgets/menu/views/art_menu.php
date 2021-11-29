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
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'art/event' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/art/events'])) ?>">
                        <i class="fas fa-snowman"></i>&#160;<?= Lang::t('События') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'art/claster' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/art/claster'])) ?>">
                        <i class="fas fa-map-signs"></i>&#160;<?= Lang::t('Арт-площадки') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'art/coworking' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/art/coworking'])) ?>">
                        <i class="fas fa-coffee"></i>&#160;<?= Lang::t('Коворкинг') ?>
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a class="top-menu-a dropdown-toggle nav-link <?= \Yii::$app->controller->id == 'art/artistic' ? 'active' : '' ?>"
                       data-toggle="dropdown" rel="nofollow" href="<?= Html::encode(Url::to(['/art/artistic'])) ?>">
                        <i class="fas fa-palette"></i></i>&#160;<?= Lang::t('Арт') ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/artistic'])) ?>">Арт в Калининграде</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/artistic/gallery'])) ?>">Галереи</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/artistic/bands'])) ?>">Мастер-классы</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/artistic/bands'])) ?>">Что-то еще ...</a>
                    </div>
                </li>
                <li class="dropdown nav-item">
                    <a class="top-menu-a dropdown-toggle nav-link <?= \Yii::$app->controller->id == 'art/word' ? 'active' : '' ?>"
                       data-toggle="dropdown" rel="nofollow" href="<?= Html::encode(Url::to(['/art/word'])) ?>">
                        <i class="fas fa-book"></i>&#160;<?= Lang::t('Поэзия') ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/word'])) ?>">Литература в Калининграде</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/word/gallery'])) ?>">Вечера</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/word/bands'])) ?>">Мастера пера</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/word/bands'])) ?>">Что-то еще ...</a>
                    </div>
                </li>

                <li class="dropdown nav-item">
                    <a class="top-menu-a dropdown-toggle nav-link <?= \Yii::$app->controller->id == 'art/music' ? 'active' : '' ?>"
                       data-toggle="dropdown" rel="nofollow" href="<?= Html::encode(Url::to(['/art/music'])) ?>">
                        <i class="fas fa-music"></i>&#160;<?= Lang::t('Музыка') ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/music'])) ?>">Музыка в Калининграде</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/music/places'])) ?>">Муз.площадки</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/music/bands'])) ?>">Музыканты</a>
                        <a class="dropdown-item" href="<?= Html::encode(Url::to(['/art/music'])) ?>">Что-то еще ...</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>

