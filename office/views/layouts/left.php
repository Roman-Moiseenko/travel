<?php

use admin\widgest\ProfileLeftBarWidget;
use booking\entities\message\Dialog;
use booking\helpers\MessageHelper;
use booking\helpers\scr;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-green elevation-4">
    <!-- Brand Logo -->
    <a href="<?= \yii\helpers\Url::home() ?>" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Kenig Travel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <?= ''//ProfileLeftBarWidget::widget()  ?>
        <!-- Sidebar Menu -->

        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Финансы', 'icon' => 'file-invoice-dollar', 'url' => ['/finance'], 'active' => $this->context->id == 'finance'],
                    ['label' => 'Активация', 'icon' => 'external-link-alt', 'url' => ['/active'], 'active' => $this->context->id == 'active'],
                    ['label' => 'Провайдеры', 'icon' => 'user-shield', 'url' => ['/providers'], 'active' => $this->context->id == 'providers'],
                    ['label' => 'Организации', 'icon' => 'registered', 'url' => ['/legals'], 'active' => $this->context->id == 'legals'],
                    ['label' => 'Туры', 'icon' => 'map-marked-alt', 'url' => ['/tours'], 'active' => $this->context->id == 'tours'],
                    ['label' => 'Жилища', 'icon' => 'hotel', 'url' => ['/stays'], 'active' => $this->context->id == 'stays'],
                    ['label' => 'Авто', 'icon' => 'car', 'url' => ['/cars'], 'active' => $this->context->id == 'cars'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/reviews'], 'active' => $this->context->id == 'reviews'],
                    ['label' => 'Диалоги', 'icon' => 'comments', 'badge' => '<span class="right badge badge-danger">' . MessageHelper::countNewSupport() . '</span>',
                        'items' => [
                            ['label' => 'От Провайдеров', 'icon' => 'comments', 'url' => ['/dialogs/provider'], 'active' => $this->context->id == 'dialogs/provider',
                                'badge' => '<span class="right badge badge-danger">' . MessageHelper::countNewSupportByType(Dialog::PROVIDER_SUPPORT) . '</span>'],
                            ['label' => 'От Клиентов', 'icon' => 'comments', 'url' => ['/dialogs/client'], 'active' => $this->context->id == 'dialogs/client',
                                'badge' => '<span class="right badge badge-danger">' . MessageHelper::countNewSupportByType(Dialog::CLIENT_SUPPORT) . '</span>'],
                            ['label' => 'Клиент - Провайдер', 'icon' => 'comments', 'url' => ['/dialogs/other'], 'active' => $this->context->id == 'dialogs/other'],
                        ]],
                    ['label' => 'Справочники', 'icon' => 'book', 'items' => [
                        ['label' => 'Туры (категории)', 'icon' => 'map-marked-alt', 'url' => ['/guides/tour-type'], 'active' => $this->context->id == 'guides/tour-type'],
                        ['label' => 'Контакты (соцсети)', 'icon' => 'share-alt-square', 'url' => ['/guides/contact-legal'], 'active' => $this->context->id == 'guides/contact-legal'],
                        ['label' => 'Темы диалогов', 'icon' => 'comment-alt', 'url' => ['/guides/theme-dialog'], 'active' => $this->context->id == 'guides/theme-dialog'],
                    ]],
                    ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/clients'], 'active' => $this->context->id == 'clients'],
                    ['label' => 'Пользователи', 'icon' => 'users-cog', 'url' => ['/users'], 'active' => $this->context->id == 'users'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>