<?php

use admin\widgest\ProfileLeftBarWidget;
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
                    ['label' => 'Мои Жилища', 'icon' => 'hotel', 'url' => ['/stays/default'], 'active' => $this->context->id == 'stays/default'],
                    ['label' => 'Мои Авто', 'icon' => 'car', 'url' => ['/cars/default'], 'active' => $this->context->id == 'cars/default'],
                    ['label' => 'Мои Туры', 'icon' => 'umbrella-beach', 'url' => ['/tours/default'], 'active' => $this->context->id == 'tours/default'],
                    ['label' => 'Отзывы', 'icon' => 'umbrella-beach', 'url' => ['/reviews/default'], 'active' => $this->context->id == 'reviews/default'],
                    ['label' => 'Бронирования', 'icon' => '', 'url' => ['/tours/default'], 'active' => $this->context->id == 'tours/default'],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>