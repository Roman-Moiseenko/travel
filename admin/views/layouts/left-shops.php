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
                    ['label' => 'Описание', 'icon' => 'align-justify', 'url' => ['/shop/view', 'id' => $this->params['id']], 'active' => $this->context->id == 'shop/view'],
                    ['label' => 'Товары', 'icon' => 'camera-retro', 'url' => ['/shop/products/'. $this->params['id']], 'active' => $this->context->id == 'shop/products'],
                    ['label' => 'Продажи/Заказы', 'icon' => 'chart-pie', 'url' => ['/shop/selling', 'id' => $this->params['id']], 'active' => $this->context->id == 'shop/selling'],
                    ['label' => 'Отчеты', 'icon' => 'hand-holding-usd', 'url' => ['/shop/report', 'id' => $this->params['id']], 'active' => $this->context->id == 'shop/report'],
                    ['label' => 'Отзывы', 'icon' => 'hand-holding-usd', 'url' => ['/shop/review', 'id' => $this->params['id']], 'active' => $this->context->id == 'shop/review'],
                    ['label' => 'koenigs.ru', 'header' => true],
                    ['label' => 'Просмотр на сайте', 'iconStyle' => 'far', 'icon' => 'eye', 'url' => Url::to(\Yii::$app->params['frontendHostInfo'] . '/shop/' . Tour::findOne($this->params['id'])->slug)],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>