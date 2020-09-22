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
         <?= ''//ProfileLeftBarWidget::widget()?>
        <!-- Sidebar Menu -->

        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Провайдеры', 'icon' => '', 'url' => ['/'], 'active' => $this->context->id == ''],
                    ['label' => 'Клиенты', 'icon' => '', 'url' => ['/'], 'active' => $this->context->id == ''],
                    ['label' => 'Справочники', 'icon' => '', 'url' => ['/'], 'active' => $this->context->id == ''],
                    ['label' => 'Пользователи', 'icon' => '', 'url' => ['/'], 'active' => $this->context->id == ''],
                    ['label' => 'Отзывы', 'icon' => '', 'url' => ['/'], 'active' => $this->context->id == ''],
                    ['label' => 'Диалоги', 'icon' => '', 'url' => ['/'], 'active' => $this->context->id == ''],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>