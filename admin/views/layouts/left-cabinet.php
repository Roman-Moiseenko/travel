<?php

use admin\widgest\ProfileLeftBarWidget;
use booking\helpers\MessageHelper;
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
                    ['label' => 'Мой Профиль', 'icon' => 'id-card', 'url' => ['/cabinet/profile'], 'active' => $this->context->id == 'cabinet/profile'],
                    ['label' => 'Мои организации', 'icon' => 'registered', 'url' => ['/cabinet/legal'], 'active' => $this->context->id == 'cabinet/legal'],
                    ['label' => 'Аутентификация', 'icon' => 'key', 'url' => ['/cabinet/auth'], 'active' => $this->context->id == 'cabinet/auth'],
                    ['label' => 'Уведомления', 'icon' => 'mail-bulk', 'url' => ['/cabinet/notice'], 'active' => $this->context->id == 'cabinet/notice'],
                    ['label' => 'Сообщения', 'icon' => 'envelope', 'url' => ['/cabinet/dialog'], 'active' => $this->context->id == 'cabinet/dialog',
                        'badge' => '<span class="right badge badge-danger">' . MessageHelper::countNew() . '</span>'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>