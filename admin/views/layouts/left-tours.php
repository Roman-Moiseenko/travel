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
                    ['label' => 'Описание', 'icon' => '', 'url' => ['/tours/common'], 'active' => $this->context->id == 'stays/default'],
                    ['label' => 'Параметры', 'icon' => '', 'url' => ['/tours/params'], 'active' => $this->context->id == 'cars/default'],
                    ['label' => 'Дополнения', 'icon' => '', 'url' => ['/tours/extra'], 'active' => $this->context->id == 'tours/default'],
                    ['label' => 'Цены', 'icon' => '', 'url' => ['/tours/finance'], 'active' => $this->context->id == 'reviews/default'],
                    ['label' => 'Бронирования', 'icon' => '', 'url' => ['/tours/booking'], 'active' => $this->context->id == 'tours/default'],
                    ['label' => 'Отзывы', 'icon' => '', 'url' => ['/tours/reviews'], 'active' => $this->context->id == 'tours/default'],
                    ['label' => 'Отчеты', 'icon' => '', 'url' => ['/tours/reports'], 'active' => $this->context->id == 'tours/default'],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>