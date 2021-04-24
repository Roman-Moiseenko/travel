<?php

use admin\widgest\BookingTopBarWidget;
use admin\widgest\MessageTopBarWidget;
use admin\widgest\ProfileTopBarWidget;
use admin\widgest\ReviewTopBarWidget;
use admin\widgest\SellingTopBarWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::home() ?>" class="nav-link">Главная</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Url::to(['/cabinet/dialog/support']) ?>" class="nav-link">Служба поддержки</a>
        </li>
        <li class="nav-item dropdown d-none d-sm-inline-block">
            <a class="nav-link" data-toggle="dropdown" href="#">
                Документы
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                <span class="dropdown-header">Документы</span>
                <div class="dropdown-divider"></div>
                <a href="<?= Url::to(\Yii::$app->params['frontendHostInfo'] . '/agreement', true) ?>"
                   class="dropdown-item" target="_blank">
                    Пользовательское соглашение
                </a>
                <a href="<?= Url::to(\Yii::$app->params['frontendHostInfo'] . '/offer', true) ?>" class="dropdown-item" target="_blank">
                    Оферта
                </a>
                <a href="<?= Url::to(\Yii::$app->params['staticHostInfo'] . '/files/docs/dogovor_provider_agregator.docx', true) ?>"
                   class="dropdown-item" target="_blank">
                    Договор (скачать)
                </a>

                <span class="dropdown-item dropdown-footer"></span>
            </div>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Url::to(['/help']) ?>" class="nav-link">Помощь</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <span id="message-widget">
            <?= MessageTopBarWidget::widget() ?>
        </span>
        <!-- Review Dropdown Menu -->
        <span id="review-widget">
            <?= ReviewTopBarWidget::widget(['days' => 7]) ?>
        </span>
        <!-- Booking Dropdown Menu -->
        <span id="booking-widget">
            <?= BookingTopBarWidget::widget() ?>
        </span>
        <span id="booking-widget">
            <?= SellingTopBarWidget::widget() ?>
        </span>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <?= ProfileTopBarWidget::widget() ?>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                        class="fas fa-th-large"></i></a>
        </li>
    </ul>
</nav>