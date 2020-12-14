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
        <span class="brand-text font-weight-light">Office Koenigs.RU</span>
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
                    ['label' => 'Финансы', 'icon' => 'ruble-sign', 'items' => [
                        ['label' => 'Выплаты провайдерам', 'icon' => 'hand-holding-usd', 'url' => ['/finance/provider'], 'active' => $this->context->id == 'finance/provider'],
                        ['label' => 'Возвраты клиентам', 'icon' => 'hand-holding-usd', 'url' => ['/finance/client'], 'active' => $this->context->id == 'finance/client'],
                        ['label' => 'Финансовый отчет', 'icon' => 'file-invoice-dollar', 'url' => ['/finance/report'], 'active' => $this->context->id == 'finance/report'],
                    ]],
                    ['label' => 'Активация', 'icon' => 'external-link-alt', 'url' => ['/active'], 'active' => $this->context->id == 'active'],
                    ['label' => 'Провайдеры', 'icon' => 'user-shield', 'url' => ['/providers'], 'active' => $this->context->id == 'providers'],
                    ['label' => 'Организации', 'icon' => 'registered', 'url' => ['/legals'], 'active' => $this->context->id == 'legals'],
                    ['label' => 'Объекты', 'icon' => 'object-group', 'items' => [
                        ['label' => ' - Туры', 'icon' => 'map-marked-alt', 'url' => ['/tours'], 'active' => $this->context->id == 'tours'],
                        ['label' => ' - Авто', 'icon' => 'car', 'url' => ['/cars'], 'active' => $this->context->id == 'cars'],
                        ['label' => ' - Развлечения', 'icon' => 'hot-tub', 'url' => ['/funs'], 'active' => $this->context->id == 'funs'],
                        ['label' => ' - Жилища', 'icon' => 'hotel', 'url' => ['/stays'], 'active' => $this->context->id == 'stays'],
                    ]],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'items' => [
                        ['label' => ' - Туры', 'icon' => 'map-marked-alt', 'url' => ['/reviews/tour'], 'active' => $this->context->id == 'reviews/tour'],
                        ['label' => ' - Авто', 'icon' => 'car', 'url' => ['/reviews/car'], 'active' => $this->context->id == 'reviews/car'],
                        ['label' => ' - Развлечения', 'icon' => 'hot-tub', 'url' => ['/reviews/fun'], 'active' => $this->context->id == 'reviews/fun'],
                        ['label' => ' - Жилища', 'icon' => 'hotel', 'url' => ['/reviews/stay'], 'active' => $this->context->id == 'reviews/stay'],
                    ]],
                    ['label' => 'Диалоги', 'icon' => 'comments', 'badge' => '<span class="right badge badge-danger">' . MessageHelper::countNewSupport() . '</span>',
                        'items' => [
                            ['label' => 'От Провайдеров', 'icon' => 'comments', 'url' => ['/dialogs/provider'], 'active' => $this->context->id == 'dialogs/provider',
                                'badge' => '<span class="right badge badge-danger">' . MessageHelper::countNewSupportByType(Dialog::PROVIDER_SUPPORT) . '</span>'],
                            ['label' => 'От Клиентов', 'icon' => 'comments', 'url' => ['/dialogs/client'], 'active' => $this->context->id == 'dialogs/client',
                                'badge' => '<span class="right badge badge-danger">' . MessageHelper::countNewSupportByType(Dialog::CLIENT_SUPPORT) . '</span>'],
                            ['label' => 'Клиент - Провайдер', 'icon' => 'comments', 'url' => ['/dialogs/other'], 'active' => $this->context->id == 'dialogs/other'],
                        ]],
                    ['label' => 'Справочники', 'icon' => 'book', 'items' => [
                        ['label' => '- Туры (категории)', 'icon' => 'map-marked-alt', 'url' => ['/guides/tour-type'], 'active' => $this->context->id == 'guides/tour-type'],
                        ['label' => '- Авто (категории)', 'icon' => 'car', 'url' => ['/guides/car-type'], 'active' => $this->context->id == 'guides/car-type'],
                        ['label' => '- Развлечения (категории)', 'icon' => 'hot-tub', 'url' => ['/guides/fun-type'], 'active' => $this->context->id == 'guides/fun-type'],
                        ['label' => '- Города ', 'icon' => 'city', 'url' => ['/guides/city'], 'active' => $this->context->id == 'guides/city'],
                        ['label' => '- Контакты (соцсети)', 'icon' => 'share-alt-square', 'url' => ['/guides/contact-legal'], 'active' => $this->context->id == 'guides/contact-legal'],
                        ['label' => '- Темы диалогов', 'icon' => 'comment-alt', 'url' => ['/guides/theme-dialog'], 'active' => $this->context->id == 'guides/theme-dialog'],
                        ['label' => '- Темы форума', 'iconStyle' => 'fab', 'icon' => 'speaker-deck', 'url' => ['/guides/theme-forum'], 'active' => $this->context->id == 'guides/theme-forum'],
                    ]],
                    ['label' => 'Страницы', 'iconStyle' => 'far', 'icon' => 'copy', 'items' => [
                        ['label' => 'Файлы', 'iconStyle' => 'far', 'icon' => 'file', 'url' => ['/file'], 'active' => $this->context->id == 'file'],
                        ['label' => 'Страницы', 'icon' => 'paste', 'url' => ['/page'], 'active' => $this->context->id == 'page'],
                        ['label' => 'Помощь (Провайдер)', 'icon' => 'info', 'url' => ['/help'], 'active' => $this->context->id == 'help'],
                    ]],
                    ['label' => 'Блог', 'icon' => 'blog', 'items' => [
                        ['label' => 'Статьи', 'icon' => 'book', 'url' => ['/blog/post'], 'active' => $this->context->id == 'blog/post'],
                        ['label' => 'Категории', 'icon' => 'folder-open', 'url' => ['/blog/category'], 'active' => $this->context->id == 'blog/category'],
                        ['label' => 'Метки', 'icon' => 'tags', 'url' => ['/blog/tag'], 'active' => $this->context->id == 'blog/tag'],
                        ['label' => 'Комментарии', 'icon' => 'comment-dots', 'url' => ['/blog/comment'], 'active' => $this->context->id == 'blog/comment'],
                    ]],
                    ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/clients'], 'active' => $this->context->id == 'clients'],
                    ['label' => 'Пользователи', 'icon' => 'users-cog', 'url' => ['/users'], 'active' => $this->context->id == 'users'],
                    ['label' => 'Рассылка', 'icon' => 'mail-bulk', 'url' => ['/mailing'], 'active' => $this->context->id == 'mailing'],
                    ['label' => 'Перевод', 'icon' => 'language', 'url' => ['/lang'], 'active' => $this->context->id == 'lang'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>