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
                    ['label' => 'Мои Туры', 'icon' => 'map-marked-alt', 'url' => ['/tours'], 'active' => $this->context->id == 'tours'],
                    ['label' => 'Мои Авто', 'icon' => 'car', 'url' => ['/cars'], 'active' => $this->context->id == 'cars'],
                    ['label' => 'Мои Развлечения', 'icon' => 'hot-tub', 'url' => ['/funs'], 'active' => $this->context->id == 'funs'],
                    ['label' => 'Мое Жилье', 'icon' => 'house-user', 'url' => ['/stays'], 'active' => $this->context->id == 'stays'],
                    ['label' => 'Мои Отели', 'icon' => 'hotel', 'url' => ['/hotels'], 'active' => $this->context->id == 'hotels'],
                    ['label' => 'Промо-коды', 'icon' => 'percent', 'url' => ['/discount'], 'active' => $this->context->id == 'discount'],
                    ['label' => 'Мои организации', 'icon' => 'registered', 'url' => ['/legal'], 'active' => $this->context->id == 'legal'],
                    ['label' => 'Сотрудники', 'icon' => 'users', 'url' => ['/staff'], 'active' => $this->context->id == 'staff'],
                    ['label' => 'Форум', 'icon' => 'volume-up', 'url' => ['/forum'], 'active' => $this->context->id == 'forum'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>