<?php

use admin\widgest\BookingTopBarWidget;
use admin\widgest\MessageTopBarWidget;
use admin\widgest\ProfileTopBarWidget;
use admin\widgest\ReviewTopBarWidget;
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
            <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Главная</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Url::to(['/cabinet/dialog/support'])?>" class="nav-link">Служба поддержки</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <?= MessageTopBarWidget::widget() ?>
        <?php //TODO Параметр days брать с параметров user->params->item Новая Entities!!! ?>
        <!-- Review Dropdown Menu -->
        <?= ReviewTopBarWidget::widget(['days' => 7]) ?>
        <!-- Booking Dropdown Menu -->
        <?= BookingTopBarWidget::widget() ?>
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