<?php

use admin\widgest\ProfileLeftBarWidget;
use booking\helpers\funs\FunHelper;
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
                    ['label' => 'Описание', 'icon' => 'align-justify', 'url' => ['/fun/common', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/common'],
                    ['label' => 'Фотографии', 'icon' => 'camera-retro', 'url' => ['/fun/photos', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/photos'],
                    ['label' => 'Параметры', 'iconStyle' => 'fab', 'icon' => 'wpforms', 'url' => ['/fun/params', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/params'],
                    ['label' => 'Дополнения', 'icon' => 'donate', 'url' => ['/fun/extra', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/extra'],
                    ['label' => 'Цены', 'icon' => 'money-check-alt', 'url' => ['/fun/finance', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/finance'],
                    ['label' => 'Календарь', 'iconStyle' => 'far', 'icon' => 'calendar-alt', 'url' => ['/fun/calendar', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/calendar'],
                    ['label' => 'Бронирования', 'icon' => 'calendar-alt', 'url' => ['/fun/booking', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/booking',
                        'badge' => '<span class="right badge badge-info">'. FunHelper::getCountActiveBooking($this->params['id']) . '</span>'],
                    ['label' => 'Отзывы', 'icon' => 'comment-dots', 'url' => ['/fun/review', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/review',
                        'badge' => '<span class="right badge badge-warning">'. FunHelper::getCountReview($this->params['id']) . '</span>'],
                    ['label' => 'Отчеты', 'icon' => 'chart-pie', 'url' => ['/fun/report', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/report'],
                    ['label' => 'Прямая продажа', 'icon' => 'hand-holding-usd', 'url' => ['/fun/selling', 'id' => $this->params['id']], 'active' => $this->context->id == 'fun/selling'],
                    ['label' => 'Просмотр на сайте', 'iconStyle' => 'far', 'icon' => 'eye', 'url' => Url::to(\Yii::$app->params['frontendHostInfo'] . '/fun/' . $this->params['id'])],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>