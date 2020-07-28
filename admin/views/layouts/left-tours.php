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
                    ['label' => 'Описание', 'icon' => '', 'url' => ['/tours/common', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/common'],
                    ['label' => 'Фотографии', 'icon' => '', 'url' => ['/tours/photos', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/photos'],
                    ['label' => 'Параметры', 'icon' => '', 'url' => ['/tours/params', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/params'],
                    ['label' => 'Дополнения', 'icon' => '', 'url' => ['/tours/extra', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/extra'],
                    ['label' => 'Цены', 'icon' => '', 'url' => ['/tours/finance', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/finance'],
                    ['label' => 'Бронирования', 'icon' => '', 'url' => ['/tours/booking', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/booking'],
                    ['label' => 'Отзывы', 'icon' => '', 'url' => ['/tours/reviews', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/reviews'],
                    ['label' => 'Отчеты', 'icon' => '', 'url' => ['/tours/reports', 'id' => $this->params['id']], 'active' => $this->context->id == 'tours/reports'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>