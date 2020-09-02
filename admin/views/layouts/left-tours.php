<?php

use admin\widgest\ProfileLeftBarWidget;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Kenig Travel</span>
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
                    ['label' => 'Описание', 'icon' => 'align-justify', 'url' => ['/tours/common', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/common'],
                    ['label' => 'Фотографии', 'icon' => 'camera-retro', 'url' => ['/tours/photos', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/photos'],
                    ['label' => 'Параметры', 'iconStyle' => 'fab', 'icon' => 'wpforms', 'url' => ['/tours/params', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/params'],
                    ['label' => 'Дополнения', 'icon' => 'donate', 'url' => ['/tours/extra', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/extra'],
                    ['label' => 'Цены', 'icon' => 'money-check-alt', 'url' => ['/tours/finance', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/finance'],
                    ['label' => 'Календарь', 'iconStyle' => 'far', 'icon' => 'calendar-alt', 'url' => ['/tours/calendar', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/calendar'],
                    ['label' => 'Бронирования', 'icon' => 'calendar-alt', 'url' => ['/tours/booking', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/booking'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/tours/review', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/review'],
                    ['label' => 'Отчеты', 'icon' => 'chart-pie', 'url' => ['/tours/report', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/report'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>