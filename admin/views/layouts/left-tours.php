<?php

use admin\widgest\ProfileLeftBarWidget;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
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
                    ['label' => 'Описание', 'icon' => 'align-justify', 'url' => ['/tour/common', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/common'],
                    ['label' => 'Фотографии', 'icon' => 'camera-retro', 'url' => ['/tour/photos', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/photos'],
                    ['label' => 'Параметры', 'iconStyle' => 'fab', 'icon' => 'wpforms', 'url' => ['/tour/params', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/params'],
                    ['label' => 'Дополнения', 'icon' => 'donate', 'url' => ['/tour/extra', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/extra'],
                    ['label' => 'Цены', 'icon' => 'money-check-alt', 'url' => ['/tour/finance', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/finance'],
                    ['label' => 'Календарь', 'iconStyle' => 'far', 'icon' => 'calendar-alt', 'url' => ['/tour/calendar', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/calendar'],
                    ['label' => 'Бронирования', 'icon' => 'calendar-alt', 'url' => ['/tour/booking', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/booking',
                        'badge' => '<span class="right badge badge-info">'. TourHelper::getCountActiveBooking($this->params['id']) . '</span>'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/tour/review', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/review',
                        'badge' => '<span class="right badge badge-warning">'. TourHelper::getCountReview($this->params['id']) . '</span>'],
                    ['label' => 'Отчеты', 'icon' => 'chart-pie', 'url' => ['/tour/report', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/report'],
                    ['label' => 'Прямая продажа', 'icon' => 'hand-holding-usd', 'url' => ['/tour/selling', 'id' => $this->params['id']], 'active' => $this->context->id == 'tour/selling'],
                    ['label' => 'koenigs.ru', 'header' => true],
                    ['label' => 'Просмотр на сайте', 'iconStyle' => 'far', 'icon' => 'eye', 'url' => Url::to(\Yii::$app->params['frontendHostInfo'] . '/tour/' . Tour::findOne($this->params['id'])->slug)],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>