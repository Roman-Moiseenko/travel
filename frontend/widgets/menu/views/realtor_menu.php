<?php

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
                       href="<?= Html::encode(Url::to(['/'])) ?>" title="<?= 'На главную' ?>">
                        <i class="fas fa-bars"></i>&#160;
                    </a>
                </li>
                <li class="nav-item nav-item-tabs <?= \Yii::$app->controller->id == 'realtor/realtor' ? 'active' : '' ?>">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/realtor' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor'])) ?>"><?= 'Покупка земли' ?>
                    </a>
                </li>
                <li class="nav-item nav-item-tabs <?= \Yii::$app->controller->id == 'realtor/landowners' ? 'active' : '' ?>">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/landowners' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor/landowners'])) ?>"><?= 'Участки под ИЖС' ?>
                    </a>
                </li>
                <li class="nav-item nav-item-tabs <?= \Yii::$app->controller->id == 'realtor/map' ? 'active' : '' ?>">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/map' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor/map'])) ?>"><?= 'Земля инвесторам' ?>
                    </a>
                </li>
                <li class="nav-item nav-item-tabs <?= \Yii::$app->controller->id == 'realtor/page' ? 'active' : '' ?>">
                    <a class="top-menu-a nav-link <?= \Yii::$app->controller->id == 'realtor/page' ? 'active' : '' ?>"
                       href="<?= Html::encode(Url::to(['/realtor/page/index'])) ?>"><?= 'Полезная информация' ?></a>
                </li>

            </ul>
        </div>
    </nav>
</div>

<!-- investment -->
