<?php

use admin\widgest\ProfileLeftBarWidget;
use booking\helpers\BookingHelper;
use booking\helpers\cars\CarHelper;
use booking\helpers\tours\TourHelper;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Koenigs.RU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
         <?= ProfileLeftBarWidget::widget()?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Описание', 'icon' => 'align-justify', 'url' => ['/car/common', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/common'],
                    ['label' => 'Фотографии', 'icon' => 'camera-retro', 'url' => ['/car/photos', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/photos'],
                    ['label' => 'Параметры', 'iconStyle' => 'fab', 'icon' => 'wpforms', 'url' => ['/car/params', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/params'],
                    ['label' => 'Дополнения', 'icon' => 'donate', 'url' => ['/car/extra', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/extra'],
                    ['label' => 'Цены', 'icon' => 'money-check-alt', 'url' => ['/car/finance', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/finance'],
                    ['label' => 'Календарь', 'iconStyle' => 'far', 'icon' => 'calendar-alt', 'url' => ['/car/calendar', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/calendar'],
                    ['label' => 'Бронирования', 'icon' => 'calendar-alt', 'url' => ['/car/booking', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/booking',
                        'badge' => '<span class="right badge badge-info">'. CarHelper::getCountActiveBooking($this->params['id']) . '</span>'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/car/review', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/review',
                        'badge' => '<span class="right badge badge-warning">'. CarHelper::getCountReview($this->params['id']) . '</span>'],
                    ['label' => 'Отчеты', 'icon' => 'chart-pie', 'url' => ['/car/report', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/report'],
                    ['label' => 'Прямая продажа', 'icon' => 'hand-holding-usd', 'url' => ['/car/selling', 'id' => $this->params['id']], 'active' => $this->context->id == 'car/selling'],
                    ['label' => 'Просмотр на сайте', 'iconStyle' => 'far', 'icon' => 'eye', 'url' => Url::to(\Yii::$app->params['frontendHostInfo'] . '/car/' . $this->params['id'])],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>