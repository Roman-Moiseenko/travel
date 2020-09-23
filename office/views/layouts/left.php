<?php

use admin\widgest\ProfileLeftBarWidget;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-green elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Kenig Travel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
         <?= ''//ProfileLeftBarWidget::widget()?>
        <!-- Sidebar Menu -->

        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Провайдеры', 'icon' => 'user-shield', 'url' => ['/providers'], 'active' => $this->context->id == 'providers'],
                    ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/clients'], 'active' => $this->context->id == 'clients'],
                    ['label' => 'Жилища', 'icon' => 'hotel', 'url' => ['/stays'], 'active' => $this->context->id == 'stays'],
                    ['label' => 'Авто', 'icon' => 'car', 'url' => ['/cars'], 'active' => $this->context->id == 'cars'],
                    ['label' => 'Туры', 'icon' => 'map-marked-alt', 'url' => ['/tours'], 'active' => $this->context->id == 'tours'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/reviews'], 'active' => $this->context->id == 'reviews'],
                    ['label' => 'Диалоги', 'icon' => 'comments', 'url' => ['/dialogs'], 'active' => $this->context->id == 'dialogs'],
                    ['label' => 'Справочники', 'icon' => 'book', 'items' => [
                        ['label' => 'Туры (категории)', 'icon' => 'map-marked-alt', 'url' => ['/guides/'], 'active' => $this->context->id == 'guides/'],
                        ['label' => 'Контакты (соцсети)', 'icon' => 'share-alt-square', 'url' => ['/guides/'], 'active' => $this->context->id == 'guides/'],
                        ['label' => 'Темы диалогов', 'icon' => 'comment-alt', 'url' => ['/guides/'], 'active' => $this->context->id == 'guides/'],
                    ]],
                    ['label' => 'Пользователи', 'icon' => 'users-cog', 'url' => ['/users'], 'active' => $this->context->id == 'users'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>